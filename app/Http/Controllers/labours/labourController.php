<?php

namespace App\Http\Controllers\labours;

use Illuminate\View\View;
use Illuminate\Http\Request;

use Psy\Readline\Hoa\Console;
use App\Models\labours\SkillTest;
use App\Models\customers\Customer;
use Illuminate\Support\Facades\DB;

use App\Models\labours\labourModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\labours\listfilesModel;
use App\Models\globalsets\GlobalSetModel;
use App\Models\managedocs\managedocsModel;
use App\Models\managedocs\managefilesModel;
use Illuminate\Support\Facades\File;

class labourController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-labour|edit-labour|delete-labour', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-labour', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-labour', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-labour', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $status = $request->input('status');
        $source = $request->input('source');
        $search = $request->input('search');

        $query = LabourModel::with(['labourStatus', 'country', 'jobGroup']);
        if (!is_null($status) && $status !== '' && $status !== 'all') {
            $query->where('labour_status', $status);
        }
        if (!is_null($source) && $source !== '' && $source !== 'all') {
            if ($source === 'api') {
                $query->where(function ($q) {
                    $q->whereNotNull('api_candidate_id')->orWhereNotNull('api_imported_at');
                });
            } elseif ($source === 'manual') {
                $query->where(function ($q) {
                    $q->whereNull('api_candidate_id')->whereNull('api_imported_at');
                });
            }
        }
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('labour_idcard_number', 'like', "%$search%")
                    ->orWhere('labour_firstname', 'like', "%$search%")
                    ->orWhere('labour_lastname', 'like', "%$search%")
                    ->orWhereRaw("CONCAT(labour_prefix, '. ', labour_firstname, ' ', labour_lastname) like ?", ["%$search%"])
                    ->orWhere('labour_phone_one', 'like', "%$search%")
                    ->orWhereHas('country', function ($q2) use ($search) {
                        $q2->where('value', 'like', "%$search%");
                    })
                    ->orWhereHas('jobGroup', function ($q2) use ($search) {
                        $q2->where('value', 'like', "%$search%");
                    });
            });
        }
        $labours = $query->orderByDesc('labour_id')->paginate(50)->appends($request->except('page'));
        $totalLabours = LabourModel::count();
        $allStatus = ['รอดำเนินการ', 'กำลังดำเนินการ', 'ดำเนินการเสร็จ', 'ยกเลิก'];
        $statusCounts = LabourModel::with('labourStatus:value,id')->select('labour_status', DB::raw('COUNT(*) as total'))->groupBy('labour_status')->get()->mapWithKeys(fn($row) => [$row->labourStatus->value ?? 'ไม่ระบุ' => $row->total])->toArray();
        $statusCounts = array_replace(array_fill_keys($allStatus, 0), $statusCounts);
        $statusGlobalSet = GlobalSetModel::with('values')->where('id', 6)->first();
        return view('labours.index', compact('totalLabours', 'statusCounts', 'statusGlobalSet', 'labours'));
    }

    public function data(Request $request)
    {
        $fallback = asset('images/user_icon.png');
        // รับ status id จาก filter (id="status-filter")
        $status = $request->input('status') ?? ($request->get('status') ?? ($_GET['status'] ?? null));

        $query = LabourModel::with('listFiles', 'country:id,value', 'jobGroup:id,value', 'labourStatus:id,value')->select(['labour_id', 'labour_prefix', 'labour_status', 'labour_firstname', 'labour_lastname', 'labour_phone_one', 'labour_image_thumbnail_path AS thumbnail', 'labour_idcard_number', 'country_id', 'job_group_id', 'api_candidate_id', 'api_imported_at', 'created_at']);

        // where labour_status = status id ที่เลือก
        if (!is_null($status) && $status !== '' && $status !== 'all') {
            $query->where('labour_status', $status);
        }

        $labours = $query->orderByDesc('labour_id')->paginate(50)->appends($request->except('page'));

        return response()->json(['data' => $labours]);
    }

    public function edit(labourModel $labour)
    {
        $hospitalGlobalSet = GlobalSetModel::with('values')->where('id', 1)->first();
        $countryGlobalSet = GlobalSetModel::with('values')->where('id', 3)->first();
        $jobGroupGlobalSet = GlobalSetModel::with('values')->where('id', 4)->first();
        $positionGlobalSet = GlobalSetModel::with('values')->where('id', 5)->first();
        $statusGlobalSet = GlobalSetModel::with('values')->where('id', 6)->first();
        $ExaminationCenterGlobalSet = GlobalSetModel::with('values')->where('id', 2)->first();
        $StaffGlobalSet = GlobalSetModel::with('values')->where('id', 7)->first();
        $StaffsubGlobalSet = GlobalSetModel::with('values')->where('id', 8)->first();
        $manageDocs = managedocsModel::latest()->get();
        $customers = Customer::latest()->get();
        $listFiles = listfilesModel::where('labour_id', $labour->labour_id)->get();
        $skillTests = SkillTest::where('labour_id', $labour->labour_id)->get();
        $statusTestGlobalSet = GlobalSetModel::with('values')->where('id', 10)->first();

        return view('labours.edit', compact('listFiles', 'skillTests', 'labour', 'statusTestGlobalSet', 'customers', 'StaffsubGlobalSet', 'StaffGlobalSet', 'ExaminationCenterGlobalSet', 'hospitalGlobalSet', 'manageDocs', 'countryGlobalSet', 'jobGroupGlobalSet', 'positionGlobalSet', 'statusGlobalSet', 'skillTests'));
    }

    public function show(labourModel $labour)
    {
        $hospitalGlobalSet = GlobalSetModel::with('values')->where('id', 1)->first();
        $countryGlobalSet = GlobalSetModel::with('values')->where('id', 3)->first();
        $jobGroupGlobalSet = GlobalSetModel::with('values')->where('id', 4)->first();
        $positionGlobalSet = GlobalSetModel::with('values')->where('id', 5)->first();
        $statusGlobalSet = GlobalSetModel::with('values')->where('id', 6)->first();
        $ExaminationCenterGlobalSet = GlobalSetModel::with('values')->where('id', 2)->first();
        $StaffGlobalSet = GlobalSetModel::with('values')->where('id', 7)->first();
        $StaffsubGlobalSet = GlobalSetModel::with('values')->where('id', 8)->first();
        $manageDocs = managedocsModel::latest()->get();
        $customers = Customer::latest()->get();
        $listFiles = listfilesModel::where('labour_id', $labour->labour_id)->get();
        $skillTests = SkillTest::where('labour_id', $labour->labour_id)->get();

        return view('labours.show', compact('listFiles', 'labour', 'customers', 'StaffsubGlobalSet', 'StaffGlobalSet', 'ExaminationCenterGlobalSet', 'hospitalGlobalSet', 'manageDocs', 'countryGlobalSet', 'jobGroupGlobalSet', 'positionGlobalSet', 'statusGlobalSet', 'skillTests'));
    }

    public function printCV($labour_id)
    {
        // Find the labour by ID
        $labour = labourModel::findOrFail($labour_id);

        // Load the same data as in the show method
        $hospitalGlobalSet = GlobalSetModel::with('values')->where('id', 1)->first();
        $countryGlobalSet = GlobalSetModel::with('values')->where('id', 3)->first();
        $jobGroupGlobalSet = GlobalSetModel::with('values')->where('id', 4)->first();
        $positionGlobalSet = GlobalSetModel::with('values')->where('id', 5)->first();
        $statusGlobalSet = GlobalSetModel::with('values')->where('id', 6)->first();
        $ExaminationCenterGlobalSet = GlobalSetModel::with('values')->where('id', 2)->first();
        $StaffGlobalSet = GlobalSetModel::with('values')->where('id', 7)->first();
        $StaffsubGlobalSet = GlobalSetModel::with('values')->where('id', 8)->first();
        $listFiles = listfilesModel::where('labour_id', $labour->labour_id)->get();

        // Return the print_cv view with the necessary data
        return view('labours.print_cv', compact('listFiles', 'labour'));
    }

    public function create(): View
    {
        $hospitalGlobalSet = GlobalSetModel::with('values')->where('id', 1)->first();
        $countryGlobalSet = GlobalSetModel::with('values')->where('id', 3)->first();
        $jobGroupGlobalSet = GlobalSetModel::with('values')->where('id', 4)->first();
        $positionGlobalSet = GlobalSetModel::with('values')->where('id', 5)->first();
        $statusGlobalSet = GlobalSetModel::with('values')->where('id', 6)->first();
        $ExaminationCenterGlobalSet = GlobalSetModel::with('values')->where('id', 2)->first();
        $StaffGlobalSet = GlobalSetModel::with('values')->where('id', 7)->first();
        $StaffsubGlobalSet = GlobalSetModel::with('values')->where('id', 8)->first();
        $statusTestGlobalSet = GlobalSetModel::with('values')->where('id', 10)->first();
        $manageDocs = managedocsModel::latest()->get();
        $customers = Customer::latest()->get();
        return view(
            'labours.create',
            compact(
                'customers',
                'StaffsubGlobalSet',
                'StaffGlobalSet',
                'ExaminationCenterGlobalSet',
                'hospitalGlobalSet',
                'manageDocs',
                'countryGlobalSet',
                'jobGroupGlobalSet',
                'positionGlobalSet',
                'statusGlobalSet',
                'statusTestGlobalSet', // ส่งตัวแปรนี้ไปที่ view ด้วย
            ),
        );
    }

    public function store(Request $request)
    {
        // ตรวจสอบเลขบัตรประชาชนว่าซ้ำหรือไม่
        $exists = labourModel::where('labour_idcard_number', $request->labour_idcard_number)->exists();

        if ($exists) {
            return 'เลขบัตรประชาชนนี้มีอยู่ในระบบแล้ว';
        }

        // หากไม่ซ้ำ ให้ทำการเพิ่มข้อมูลใหม่
        $requestData = $request->all();
        if (!empty($requestData['weight']) && !empty($requestData['height']) && $requestData['height'] > 0) {
            $requestData['bmi'] = round($requestData['weight'] / pow($requestData['height'] / 100, 2), 2);
        }
        $requestData['created_by'] = Auth::user()->name;
        $labours = labourModel::create($requestData);

        // === เพิ่ม listfilesModel ===
        if (!empty($labours->managedoc_id)) {
            $managefiles = managefilesModel::where('managedoc_id', $labours->managedoc_id)->get();
            foreach ($managefiles as $item) {
                listfilesModel::create([
                    'labour_id' => $labours->labour_id,
                    'managedoc_id' => $labours->managedoc_id,
                    'managefile_id' => $item->managefile_id,
                    'managefile_no' => $item->managefile_no,
                    'managefile_code' => $item->managefile_code,
                    'managefile_name' => $item->managefile_name,
                    'managefile_step' => $item->managefile_step,
                    'file_path' => null,
                ]);
            }
        }

        // === เพิ่มบันทึก skill test ===
        $skillTests = $request->input('skill_tests', []);
        if (empty($skillTests)) {
            foreach ($skillTests as $test) {
                SkillTest::create([
                    'labour_id' => $labours->labour_id,
                    'customer_id' => $test['customer_id'] ?? null,
                    'test_date' => $test['test_date'] ?? null,
                    'test_location_id' => $test['test_location_id'] ?? null,
                    'test_position_id' => $test['test_position_id'] ?? null,
                    'test_result_id' => $test['test_result_id'] ?? null,
                    'note' => $test['note'] ?? null,
                ]);
            }
        }
        // === จบ skill test ===

        // ส่งข้อมูลไปยัง API ภายนอก พร้อมแนบ Bearer Token
        $apiSuccess = false;
        try {
            $payload = [
                'name' => trim(($labours->labour_firstname ?? '') . ' ' . ($labours->labour_lastname ?? '')),
                'email' => $labours->labour_email ?? '',
                'mobile' => $labours->labour_phone_one ?? '',
                'idcard' => $labours->labour_idcard_number ?? '',
                'birthday' => $labours->labour_birthday ?? '',
                'emergencyname' => $labours->labour_emergency_contact_name ?? '',
                'emergencymobile' => $labours->labour_phone_one ?? '',
            ];
            $token = config('thailabor.api_token', '');
            $response = \Illuminate\Support\Facades\Http::withToken($token)->post('https://thailaborland.com/api/createaccount', $payload);
            if ($response->status() === 200) {
                $apiSuccess = true;
            }
        } catch (\Exception $e) {
            // สามารถ log error ได้ถ้าต้องการ
            // Console::$response->status();
        }

        $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
        if ($apiSuccess) {
            $msg .= ' (ส่งข้อมูลไปยัง thailaborland.com สำเร็จ)';
        }
        return redirect()->route('home')->with('success', $msg);
    }

    public function update(Request $request, labourModel $labour)
    {
        $managedocNew = $request->managedoc_id;
        $managedocOld = $labour->managedoc_id;

         // เช็คเฉพาะตอนเปลี่ยน managedoc_id
    if ($managedocNew !== $managedocOld) {
        // ลบรายการเดิมทั้งหมดก่อนเพิ่มใหม่
        listfilesModel::where('labour_id', $labour->labour_id)->delete();

        $managefiles = managefilesModel::where('managedoc_id', $managedocNew)->get();
        foreach ($managefiles as $item) {
            listfilesModel::create([
                'labour_id' => $labour->labour_id,
                'managedoc_id' => $managedocNew,
                'managefile_id' => $item->managefile_id,
                'managefile_no' => $item->managefile_no,
                'managefile_code' => $item->managefile_code,
                'managefile_name' => $item->managefile_name,
                'managefile_step' => $item->managefile_step,
                'file_path' => null,
            ]);
        }
    }

        $updateData = $request->all();
        if (!empty($updateData['weight']) && !empty($updateData['height']) && $updateData['height'] > 0) {
            $updateData['bmi'] = round($updateData['weight'] / pow($updateData['height'] / 100, 2), 2);
        }
        $labour->update($updateData);

        // === อัปเดต skill test ===
        // ลบ skill test เดิม
        SkillTest::where('labour_id', $labour->labour_id)->delete();
        // เพิ่ม skill test ใหม่
        $skillTests = $request->input('skill_tests', []);
        if (empty($skillTests)) {
            foreach ($skillTests as $test) {
                SkillTest::create([
                    'labour_id' => $labour->labour_id,
                    'test_date' => $test['test_date'] ?? null,
                    'customer_id' => $test['customer_id'] ?? null,
                    'test_location_id' => $test['test_location_id'] ?? null,
                    'test_position_id' => $test['test_position_id'] ?? null,
                    'test_result_id' => $test['test_result_id'] ?? null,
                    'note' => $test['note'] ?? null,
                ]);
            }
        }
        // === จบ skill test ===

        return redirect()->back();
    }

    public function destroy(labourModel $labour)
    {
        $labour->delete();
        return redirect()->route('labours.index')->with('success', 'เพิ่มข้อมูลเรียบร้อยแล้ว');
    }

    public function addListFile(Request $request, $labour_id)
    {

        $listFile = listfilesModel::where('labour_id', $labour_id)->first();
        $request->validate([
            'managefile_code' => 'required',
            'managefile_name' => 'required',
            'managefile_step' => 'required',
        ]);
        if (!$listFile) {
            return redirect()->back()->with('success', 'ไม่พบรายการจัดเก็บเอกสาร');
        }
        $listFile = new listfilesModel();
        $listFile->labour_id = $labour_id;
        $listFile->managefile_id = $listFile->managefile_id;
        $listFile->managedoc_id = $listFile->managedoc_id;
        $listFile->managefile_code = $request->managefile_code;
        $listFile->managefile_name = $request->managefile_name;
        $listFile->managefile_step = $request->managefile_step;
        $listFile->file_path = null;
        $listFile->save();
        return redirect()->back()->with('success', 'เพิ่มรายการเอกสารสำเร็จ');
    }

   public function deleteListFile($labour_id, $list_file)
{
    $file = listfilesModel::where('list_file_id', $list_file)
        ->where('labour_id', $labour_id)
        ->first();

    if (!$file) {
        return redirect()->back()->with('error', 'ไม่พบรายการเอกสาร');
    }

    if ($file->file_path) {
        $oldAbs = storage_path("app/public/{$file->file_path}");
        if (File::exists($oldAbs)) {
            File::delete($oldAbs);
        }
    }
    $file->delete();
    return redirect()->back()->with('success', 'ลบรายการเอกสารสำเร็จ');
}
}
