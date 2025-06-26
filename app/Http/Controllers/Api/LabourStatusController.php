<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\labours\labourModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class LabourStatusController extends Controller
{
    /**
     * รับสถานะจากระบบภายนอกเมื่อมีการส่งข้อมูลสำเร็จ
     */
    public function receiveStatus(Request $request)
    {
        try {
            $data = $request->validate([
                'labour_id' => 'required|integer',
                'status' => 'required|string',
                'message' => 'nullable|string',
                'external_id' => 'nullable|string|integer'
            ]);

            // ค้นหา Labour
            $labour = labourModel::find($data['labour_id']);
            
            if (!$labour) {
                return response()->json([
                    'success' => false,
                    'message' => 'ไม่พบข้อมูลแรงงาน'
                ], 404);
            }

            // บันทึก log
            Log::info('External Status Received', [
                'labour_id' => $data['labour_id'],
                'status' => $data['status'],
                'message' => $data['message'] ?? null,
                'external_id' => $data['external_id'] ?? null
            ]);

            // อัปเดตสถานะหากจำเป็น
            if ($data['status'] === 'success') {
                // สามารถอัปเดตสถานะ Labour ได้ที่นี่
                // $labour->update(['some_status_field' => 'completed']);
            }

            return response()->json([
                'success' => true,
                'message' => 'รับสถานะสำเร็จ',
                'labour_id' => $labour->labour_id
            ], 200);

        } catch (\Exception $e) {
            Log::error('API Status Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาด'
            ], 500);
        }
    }

    /**
     * ส่งสถานะกลับไปยังระบบภายนอก
     */
    public function sendStatus($labourId, Request $request)
    {
        try {
            $labour = labourModel::findOrFail($labourId);

            // ข้อมูลที่จะส่งกลับ
            $statusData = [
                'labour_id' => $labour->labour_id,
                'status' => 'success',
                'message' => 'ข้อมูลถูกบันทึกเรียบร้อยแล้ว',
                'created_at' => $labour->created_at->toISOString(),
                'data' => [
                    'name' => $labour->labour_firstname . ' ' . $labour->labour_lastname,
                    'phone' => $labour->labour_phone_one,
                    'country' => $labour->country?->value,
                    'position' => $labour->position?->value,
                    'status' => $labour->labourStatus?->value
                ]
            ];

            // หาก API ระบบภายนอกต้องการ POST กลับ
            if ($request->has('callback_url')) {
                $this->sendCallbackToExternalAPI($request->callback_url, $statusData);
            }

            return response()->json($statusData, 200);

        } catch (\Exception $e) {
            Log::error('Send Status Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาด',
                'labour_id' => $labourId
            ], 500);
        }
    }

    /**
     * ส่ง callback ไปยัง External API
     */
    private function sendCallbackToExternalAPI($callbackUrl, $data)
    {
        try {
            // ใช้ HTTP Client ส่งข้อมูลกลับ
            $response = Http::timeout(30)
                ->post($callbackUrl, $data);

            Log::info('Callback sent to external API', [
                'url' => $callbackUrl,
                'response_status' => $response->status(),
                'data' => $data
            ]);

        } catch (\Exception $e) {
            Log::error('Callback Error: ' . $e->getMessage(), [
                'url' => $callbackUrl,
                'data' => $data
            ]);
        }
    }
}
