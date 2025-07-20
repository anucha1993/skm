<?php

namespace App\Http\Controllers\labours;

use App\Http\Controllers\Controller;
use App\Models\globalsets\GlobalSetModel;
use App\Models\globalsets\GlobalSetValueModel;
use App\Models\labours\labourModel;
use App\Services\TokenService;
use App\Services\GlobalSetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImportLabourController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-labour', ['only' => ['index']]);
    }

    public function index()
    {
        // ดึงข้อมูลจาก API
        $candidates = $this->fetchCandidatesFromAPI();

        // ดึง id ที่มีในระบบแล้ว
        $candidateIds = collect($candidates)->pluck('id')->toArray();
        $existingIds = [];
        if (!empty($candidateIds)) {
            $existingIds = labourModel::whereIn('api_candidate_id', $candidateIds)
                ->whereNotNull('api_candidate_id')
                ->pluck('api_candidate_id')
                ->map(fn($id) => (string)$id)
                ->toArray();
        }

        // กรอง candidates เฉพาะที่ยังไม่มีในระบบ
        $candidates = collect($candidates)->reject(function($c) use ($existingIds) {
            return in_array((string)($c['id'] ?? ''), $existingIds);
        })->values()->all();

        // นับจำนวน labour ที่แปลงแล้วจาก API candidates (เฉพาะที่มีในระบบ)
        $convertedCount = count($existingIds);
        $totalCandidates = count($candidates) + $convertedCount;
        $pendingCount = count($candidates);

        // สร้าง array เพื่อระบุว่า candidate ไหนถูก convert แล้ว
        $convertedCandidateIds = $existingIds;

        return view('labours.import-index', compact('candidates', 'convertedCount', 'pendingCount', 'totalCandidates', 'convertedCandidateIds'));
    }

    public function convert(Request $request, $id)
    {
        try {
            Log::info("Starting conversion for candidate ID: {$id}");

            // ดึงข้อมูลจาก API โดยใช้ ID
            $candidate = $this->fetchCandidateFromAPI($id);

            if (!$candidate) {
                Log::warning("Candidate not found for ID: {$id}");
                return response()->json(['message' => 'ไม่พบข้อมูลจาก API'], 404);
            }

            Log::info('Found candidate, starting conversion process');

            // แปลงข้อมูลและสร้าง Labour
            $labour = $this->convertCandidateToLabour($candidate);

            Log::info("Labour created successfully with ID: {$labour->labour_id}");

            // ส่งสถานะ 200 กลับไปยัง External API 
            $this->notifyExternalAPI($id, $labour);

            // เตรียมข้อมูลสำหรับ updateapi
            $updateApiData = [
                'success' => true,
                'message' => 'แปลงข้อมูลสำเร็จ',
                'labour_id' => $labour->labour_id,
                'apiid' => $labour->api_candidate_id,
                'redirect' => route('labours.edit', $labour->labour_id),
            ];

            // เรียก API updateapi
            try {
                $token = env('LABOUR_API_TOKEN') ?: TokenService::fetchAndStoreToken();
                $updateApiUrl = 'https://thailaborland.com/api/updateapi';
                // Log ข้อมูลที่จะส่งไป updateapi
                Log::info('Preparing to call updateapi', [
                    'url' => $updateApiUrl,
                    'data' => $updateApiData,
                ]);
                $response = \Illuminate\Support\Facades\Http::withToken($token)
                    ->timeout(30)
                    ->post($updateApiUrl, $updateApiData);
                Log::info('Called updateapi', [
                    'url' => $updateApiUrl,
                    'status' => $response->status(),
                    'body' => $updateApiData,
                ]);
            } catch (\Exception $ex) {
                Log::error('Call to updateapi failed: ' . $ex->getMessage());
            }

            return response()->json($updateApiData, 200);


        } catch (\Exception $e) {
            Log::error('Import Labour Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            // ส่งสถานะ error กลับไป API หากจำเป็น
            $this->notifyExternalAPIError($id, $e->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }

    private function fetchCandidatesFromAPI()
    {
        try {
            $token = env('LABOUR_API_TOKEN') ?: TokenService::fetchAndStoreToken();

            $response = Http::withToken($token)->get('https://thailaborland.com/api/getuserpass');

            if ($response->status() === 401) {
                $token = TokenService::fetchAndStoreToken();
                $response = Http::withToken($token)->get('https://thailaborland.com/api/getuserpass');
            }

            if ($response->successful()) {
                $data = $response->json();
                return is_array($data) && isset($data[0]) ? $data : $data['data'] ?? [];
            }

            return [];
        } catch (\Exception $e) {
            Log::error('API Fetch Error: ' . $e->getMessage());
            return [];
        }
    }

    private function fetchCandidateFromAPI($id)
    {
        try {
            // เนื่องจาก API อาจไม่มี endpoint สำหรับดึงข้อมูลเดี่ยว
            // ให้ดึงทั้งหมดแล้วหา ID ที่ต้องการ
            $candidates = $this->fetchCandidatesFromAPI();

            Log::info("Searching for candidate ID: {$id} in " . count($candidates) . ' candidates');

            $candidate = collect($candidates)->firstWhere('id', (string) $id);

            if ($candidate) {
                Log::info('Found candidate: ' . json_encode($candidate));
                return $candidate;
            }

            Log::warning("Candidate with ID {$id} not found");
            return null;
        } catch (\Exception $e) {
            Log::error('API Fetch Single Error: ' . $e->getMessage());
            return null;
        }
    }

    private function convertCandidateToLabour($candidate)
    {
        // เตรียม mapping ข้อมูล
        $mappedData = $this->mapCandidateData($candidate);

        // ตรวจสอบเลขบัตรประชาชนว่าซ้ำหรือไม่
        if (isset($mappedData['labour_idcard_number'])) {
            $exists = labourModel::where('labour_idcard_number', $mappedData['labour_idcard_number'])->exists();
            if ($exists) {
                throw new \Exception('เลขบัตรประชาชนนี้มีอยู่ในระบบแล้ว');
            }
        }

        // เพิ่มข้อมูล API tracking
        $mappedData['created_by'] = Auth::user()->name ?? 'API Import';
        $mappedData['api_imported_at'] = now();
        $mappedData['api_candidate_id'] = $candidate['id'] ?? null;

        // สร้าง Labour
        $labour = labourModel::create($mappedData);

        // === ดาวน์โหลดและอัปโหลดภาพโปรไฟล์ ถ้ามี ===
        if (!empty($candidate['image']) && filter_var($candidate['image'], FILTER_VALIDATE_URL)) {
            try {
                $this->downloadAndUploadProfileImage($candidate['image'], $labour);
            } catch (\Exception $e) {
                Log::warning('Profile image import failed: ' . $e->getMessage());
            }
        }

        return $labour;
    }

    /**
     * ดาวน์โหลดไฟล์ภาพจาก URL แล้วอัปโหลดเข้า storage และอัปเดต labour
     */
    private function downloadAndUploadProfileImage($imageUrl, $labour)
    {
        // ดาวน์โหลดไฟล์
        $tmpPath = storage_path('app/tmp_profile_' . uniqid());
        $client = new \GuzzleHttp\Client(['verify' => false]);
        $res = $client->get($imageUrl, ['sink' => $tmpPath, 'timeout' => 30]);
        if ($res->getStatusCode() !== 200) {
            throw new \Exception('Download failed: ' . $imageUrl);
        }

        // ตรวจสอบ mime-type และตั้ง extension ให้ถูกต้อง
        $mime = null;
        $ext = null;
        if (function_exists('mime_content_type')) {
            $mime = mime_content_type($tmpPath);
        }
        if (!$mime) {
            $mime = $res->getHeaderLine('Content-Type');
        }
        // รองรับเฉพาะ jpg/png/webp/gif
        switch ($mime) {
            case 'image/jpeg': $ext = 'jpg'; break;
            case 'image/png': $ext = 'png'; break;
            case 'image/webp': $ext = 'webp'; break;
            case 'image/gif': $ext = 'gif'; break;
            default: $ext = 'jpg'; break;
        }
        $finalPath = $tmpPath . '.' . $ext;
        rename($tmpPath, $finalPath);

        // สร้าง UploadedFile จำลอง
        $uploadedFile = new \Illuminate\Http\UploadedFile(
            $finalPath,
            basename($finalPath),
            $mime ?: 'image/jpeg',
            null,
            true // $test mode
        );

        // เรียกใช้ controller uploadImage (จำลอง request)
        $request = new \Illuminate\Http\Request();
        $request->files->set('image_profile', $uploadedFile);

        // ต้องใช้ controller โดยตรง (หรือ service ถ้ามี)
        $uploader = app(\App\Http\Controllers\labours\labourUploadImageProfileController::class);
        $uploader->uploadImage($request, $labour);

        // ลบไฟล์ temp
        @unlink($finalPath);
    }

    private function mapCandidateData($candidate)
    {
        try {
            $mappedData = [];

            // ชื่อ-นามสกุล จาก nameeng หรือ nameth
            $fullName = $candidate['nameeng'] ?? ($candidate['nameth'] ?? '');
            if ($fullName) {
                $nameParts = explode(' ', trim($fullName), 2);
                $mappedData['labour_firstname'] = $nameParts[0] ?? '';
                $mappedData['labour_lastname'] = $nameParts[1] ?? '';
            }

            // เพิ่มบัตรประชาชน (idcard) -> labour_idcard_number
            if (!empty($candidate['idcard'])) {
                $mappedData['labour_idcard_number'] = preg_replace('/[^0-9]/', '', $candidate['idcard']);
            }

            // ข้อมูลการติดต่อจาก contract
            if (isset($candidate['contract']) && is_array($candidate['contract'])) {
                $contract = $candidate['contract'];

                // ข้อมูลพื้นฐาน
                $mappedData['labour_phone_one'] = $contract['tel'] ?? '';
                $mappedData['labour_phone_two'] = $contract['emergencytel'] ?? '';
                $mappedData['labour_email'] = $contract['email'] ?? '';
                $mappedData['labour_line_id'] = $contract['lineid'] ?? '';
                $mappedData['labour_emergency_contact_name'] = $contract['emergencyname'] ?? '';

                // ข้อมูลที่อยู่
                $mappedData['labour_address'] = $contract['address'] ?? '';
                $mappedData['labour_address_type'] = $contract['addresstype'] ?? '';
                $mappedData['labour_province'] = $contract['province'] ?? '';
                $mappedData['labour_district'] = $contract['distric'] ?? '';
                $mappedData['labour_sub_district'] = $contract['sub distric'] ?? '';
                $mappedData['labour_postcode'] = $contract['postcode'] ?? '';

                // เก็บข้อมูลเพิ่มเติมใน note (ลดลงเพราะเก็บในฟิลด์แยกแล้ว)
                $notes = [];
                if (!empty($contract['addresstype'])) {
                    $notes[] = 'ประเภทที่อยู่: ' . $contract['addresstype'];
                }

                if (!empty($notes)) {
                    $mappedData['labour_note'] = implode(' | ', $notes);
                }
            }

            // วันเกิด
            if (isset($candidate['birthdate'])) {
                $birthdate = $this->convertThaiDate($candidate['birthdate']);
                if ($birthdate) {
                    $mappedData['labour_birthday'] = $birthdate;
                }
            }

            // ข้อมูลงานที่สนใจ - เพิ่ม try-catch สำหรับ GlobalSetService
            if (isset($candidate['interests']) && is_array($candidate['interests'])) {
                $interests = $candidate['interests'];

                try {
                    if (!empty($interests['country'])) {
                        $mappedData['country_id'] = GlobalSetService::findOrCreateValue(3, $interests['country']);
                    }
                } catch (\Exception $e) {
                    Log::warning('Failed to map country: ' . $e->getMessage());
                }

                try {
                    if (!empty($interests['jobtype'])) {
                        $mappedData['job_group_id'] = GlobalSetService::findOrCreateValue(4, $interests['jobtype']);
                    }
                } catch (\Exception $e) {
                    Log::warning('Failed to map jobtype: ' . $e->getMessage());
                }
            }

            // ทักษะ/ความสามารถ
            if (isset($candidate['skill']) && !empty($candidate['skill'])) {
                $skills = explode(',', $candidate['skill']);
                $primarySkill = trim($skills[0] ?? '');
                if ($primarySkill) {
                    try {
                        $mappedData['position_id'] = GlobalSetService::findOrCreateValue(5, $primarySkill);
                    } catch (\Exception $e) {
                        Log::warning('Failed to map skill: ' . $e->getMessage());
                    }
                }
            }

            // ข้อมูลการศึกษา (เก็บใน note เพิ่มเติม)
            if (isset($candidate['education'])) {
                $education = $candidate['education'];
                $educationInfo = sprintf('การศึกษา: %s สาขา%s จาก%s ปีที่จบ:%s', $education['level'] ?? '', $education['branch'] ?? '', $education['institution'] ?? '', $education['graduationyear'] ?? '');
                $mappedData['labour_note'] = ($mappedData['labour_note'] ?? '') . ' | ' . $educationInfo;
            }

            // กำหนด prefix ตามชื่อ
            $mappedData['labour_prefix'] = $this->determinePrefix($candidate['nameeng'] ?? ($candidate['nameth'] ?? ''));

            // สถานะเริ่มต้น - ใช้ฟังก์ชัน getDefaultStatus
            try {
                $mappedData['labour_status'] = $this->getDefaultStatus();
            } catch (\Exception $e) {
                Log::warning('Failed to get default status, using fallback: ' . $e->getMessage());
                $mappedData['labour_status'] = 1; // Fallback status
            }

           
            if (isset($candidate['w'])) {
                // น้ำหนัก - อาจเก็บใน note
                $mappedData['weight'] = ($candidate['w'] ?? NULL);
            }

            if (isset($candidate['h']) && !empty($candidate['h'])) {
                // ส่วนสูง - อาจเก็บใน note
                $mappedData['height'] = ($candidate['h'] ?? NULL);
            }

            // เพิ่มค่าเริ่มต้นที่จำเป็น
            $mappedData['company_id'] = $mappedData['company_id'] ?? 1; // Default company

            Log::info('Mapped data successfully: ' . json_encode($mappedData));

            return $mappedData;
        } catch (\Exception $e) {
            Log::error('Error in mapCandidateData: ' . $e->getMessage());
            throw new \Exception('ไม่สามารถแปลงข้อมูลได้: ' . $e->getMessage());
        }
    }

    /**
     * แปลงวันที่ไทย (dd-mm-yyyy พ.ศ.) หรือ yyyy-mm-dd (ค.ศ.) เป็น Y-m-d
     */
    private function convertThaiDate($thaiDate)
    {
        try {
            $parts = explode('-', $thaiDate);
            if (count($parts) === 3) {
                // ถ้า format เป็น dd-mm-yyyy และปี > 2400 ให้ลบ 543
                if (strlen($parts[2]) === 4 && (int)$parts[2] > 2400) {
                    $day = $parts[0];
                    $month = $parts[1];
                    $year = (int)$parts[2] - 543;
                    return sprintf('%04d-%02d-%02d', $year, $month, $day);
                }
                // ถ้า format เป็น yyyy-mm-dd (ค.ศ.) ให้ return เดิม
                if (strlen($parts[0]) === 4 && (int)$parts[0] > 1900 && (int)$parts[0] < 2500) {
                    return $thaiDate;
                }
            }
        } catch (\Exception $e) {
            Log::warning('Date conversion error: ' . $e->getMessage(), ['date' => $thaiDate]);
        }
        return null;
    }

    private function determinePrefix($name)
    {
        // Logic สำหรับกำหนด prefix ตามชื่อ
        $name = strtolower($name);

        if (strpos($name, 'mr.') !== false || strpos($name, 'นาย') !== false) {
            return 'Mr';
        }

        if (strpos($name, 'mrs.') !== false || strpos($name, 'นาง') !== false) {
            return 'Ms';
        }

        if (strpos($name, 'miss') !== false || strpos($name, 'น.ส.') !== false) {
            return 'Miss';
        }

        // Default
        return 'Mr';
    }

    private function getDefaultStatus()
    {
        // หาสถานะเริ่มต้น "รอดำเนินการ" หรือสร้างใหม่
        return GlobalSetService::findOrCreateValue(6, 'รอดำเนินการ');
    }

    /**
     * แจ้งผลลัพธ์กลับไปยัง External API
     */
    private function notifyExternalAPI($candidateId, $labour)
    {
        try {
            $token = env('LABOUR_API_TOKEN') ?: TokenService::fetchAndStoreToken();
            $callbackUrl = env('LABOUR_API_CALLBACK_URL');

            if (!$callbackUrl) {
                Log::info('No callback URL configured, skipping external notification');
                return;
            }

            $statusData = [
                'candidate_id' => $candidateId,
                'labour_id' => $labour->labour_id,
                'status' => 'success',
                'message' => 'ข้อมูลถูกนำเข้าและบันทึกเรียบร้อยแล้ว',
                'processed_at' => now()->toISOString(),
                'data' => [
                    'name' => $labour->labour_firstname . ' ' . $labour->labour_lastname,
                    'phone' => $labour->labour_phone_one,
                    'country' => $labour->country?->value,
                    'position' => $labour->position?->value,
                    'status' => $labour->labourStatus?->value,
                    'internal_id' => $labour->labour_id,
                ],
            ];

            // ส่งข้อมูลกลับ
            $response = Http::withToken($token)->timeout(30)->post($callbackUrl, $statusData);

            Log::info('External API Notification Sent', [
                'candidate_id' => $candidateId,
                'labour_id' => $labour->labour_id,
                'status_code' => $response->status(),
                'callback_url' => $callbackUrl,
            ]);
        } catch (\Exception $e) {
            Log::error('External API Notification Error: ' . $e->getMessage(), [
                'candidate_id' => $candidateId,
                'labour_id' => $labour->labour_id ?? null,
            ]);
        }
    }

    /**
     * แจ้งข้อผิดพลาดกลับไปยัง External API
     */
    private function notifyExternalAPIError($candidateId, $errorMessage)
    {
        try {
            $token = env('LABOUR_API_TOKEN') ?: TokenService::fetchAndStoreToken();
            $callbackUrl = env('LABOUR_API_CALLBACK_URL');

            if (!$callbackUrl) {
                return;
            }

            $errorData = [
                'candidate_id' => $candidateId,
                'status' => 'error',
                'message' => $errorMessage,
                'processed_at' => now()->toISOString(),
            ];

            Http::withToken($token)->timeout(30)->post($callbackUrl, $errorData);

            Log::info('External API Error Notification Sent', [
                'candidate_id' => $candidateId,
                'error' => $errorMessage,
            ]);
        } catch (\Exception $e) {
            Log::error('External API Error Notification Failed: ' . $e->getMessage());
        }
    }

    /**
     * Method สำหรับทดสอบด้วยข้อมูลตัวอย่าง
     */
    public function test()
    {
        $sampleData = [
            [
                'id' => '6',
                'nameeng' => 'Phoovanon Sonkanit',
                'nameth' => 'ภูวนนท์ สอนคณิต',
                'w' => '61',
                'h' => '',
                'age' => '40',
                'skill' => 'ก่อสร้าง-ช่างไม้,ก่อสร้าง-ช่างกระเบื้อง,ก่อสร้าง-ช่างปูน,ก่อสร้าง-ช่างเหล็ก',
                'birthdate' => '12-01-2525',
                'contract' => [
                    'tel' => null,
                    'lineid' => 'tayphoo',
                    'email' => 'phoo319@gmail.com',
                    'emergencyname' => 'น้องสาว',
                    'emergencytel' => '0659214125',
                    'addresstype' => 'ตามบัตรประชาชน',
                    'address' => '1600 Amphitheatre Parkway',
                    'province' => 'กรุงเทพมหานคร',
                    'distric' => 'เขตพระนคร',
                    'sub distric' => 'วังบูรพาภิรมย์',
                    'postcode' => '10210',
                ],
                'interests' => [
                    'jobtype' => 'ก่อสร้าง-ช่างไม้',
                    'country' => 'เกาหลี',
                    'description' => 'รายละเอียดเพิ่มเติม',
                ],
                'education' => [
                    'level' => 'ปริญญาตรี',
                    'branch' => 'เกษตรศาสตร์',
                    'institution' => 'บูรพา',
                    'graduationyear' => '2518',
                ],
            ],
        ];

        return view('labours.import-index', ['candidates' => $sampleData]);
    }

    public function testConvert($id = null)
    {
        // ใช้สำหรับทดสอบระบบ convert โดยไม่ต้องเชื่อมต่อ API จริง
        $sampleData = [
            'id' => $id ?: '999',
            'nameeng' => 'Test User',
            'nameth' => 'ผู้ใช้ทดสอบ',
            'age' => '30',
            'skill' => 'ก่อสร้าง-ช่างไม้',
            'birthdate' => '01-01-2550',
            'contract' => [
                'tel' => '0812345678',
                'email' => 'test@example.com',
                'province' => 'กรุงเทพมหานคร',
            ],
            'interests' => [
                'jobtype' => 'ก่อสร้าง-ช่างไม้',
                'country' => 'ญี่ปุ่น',
            ],
            'education' => [
                'level' => 'มัธยมศึกษา',
                'branch' => 'สายทั่วไป',
                'institution' => 'โรงเรียนทดสอบ',
            ],
        ];

        try {
            Log::info("Test conversion starting for ID: {$sampleData['id']}");

            // ตรวจสอบ GlobalSetService ก่อน
            if (!class_exists('App\Services\GlobalSetService')) {
                throw new \Exception('GlobalSetService not found');
            }

            // ตรวจสอบ labourModel ก่อน
            if (!class_exists('App\Models\labours\labourModel')) {
                throw new \Exception('labourModel not found');
            }

            // ทดสอบ mapping ข้อมูลก่อน
            $mappedData = $this->mapCandidateData($sampleData);
            Log::info('Mapped data: ' . json_encode($mappedData));

            // ทดสอบสร้าง Labour
            $labour = $this->convertCandidateToLabour($sampleData);

            Log::info("Test Labour created with ID: {$labour->labour_id}");

            return response()->json(
                [
                    'success' => true,
                    'message' => 'ทดสอบแปลงข้อมูลสำเร็จ',
                    'labour_id' => $labour->labour_id,
                    'redirect' => route('labours.edit', $labour->labour_id),
                    'test_mode' => true,
                    'mapped_data' => $mappedData,
                ],
                200,
            );
        } catch (\Exception $e) {
            Log::error('Test Convert Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Log::error('Sample data: ' . json_encode($sampleData));

            return response()->json(
                [
                    'success' => false,
                    'message' => 'ทดสอบไม่สำเร็จ: ' . $e->getMessage(),
                    'error_details' => [
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => $e->getTraceAsString(),
                    ],
                    'test_mode' => true,
                ],
                500,
            );
        }
    }

    /**
     * Method สำหรับทดสอบการแปลงข้อมูลแบบละเอียด
     */
    public function debugConvert(Request $request, $id)
    {
        try {
            Log::info('=== DEBUG CONVERT START ===');
            Log::info("Candidate ID: {$id}");

            // Step 1: Fetch candidate data
            Log::info('Step 1: Fetching candidate data');
            $candidate = $this->fetchCandidateFromAPI($id);

            if (!$candidate) {
                Log::error('Candidate not found');
                return response()->json(['message' => 'Candidate not found'], 404);
            }

            Log::info('Step 2: Raw candidate data', $candidate);

            // Step 2: Test mapping
            Log::info('Step 3: Testing data mapping');
            $mappedData = $this->mapCandidateData($candidate);
            Log::info('Step 4: Mapped data result', $mappedData);

            // Step 3: Check required fields
            $requiredFields = ['labour_firstname', 'labour_lastname'];
            foreach ($requiredFields as $field) {
                if (empty($mappedData[$field])) {
                    Log::warning("Missing required field: {$field}");
                }
            }

            // Step 4: Test Labour model creation (dry run)
            Log::info('Step 5: Testing Labour model validation');
            $labour = new labourModel($mappedData);
            Log::info('Labour model created successfully (dry run)');

            Log::info('=== DEBUG CONVERT END ===');

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Debug completed successfully',
                    'raw_data' => $candidate,
                    'mapped_data' => $mappedData,
                    'validation' => 'passed',
                ],
                200,
            );
        } catch (\Exception $e) {
            Log::error('Debug Convert Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Debug failed: ' . $e->getMessage(),
                    'error_details' => [
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                    ],
                ],
                500,
            );
        }
    }
}
