<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LabourApiController extends Controller
{
    //
    public function getMockData()
    {
        $data = [
            [
                "VISA_ID" => "N00893101",
                "สถานะพนักงาน" => "ทำงาน",
                "รหัสพนักงานของนายจ้าง" => "10612891",
                "สัญชาติ" => "อิสราเอล",
                "Agency" => "บริษัท ABC",
                "เลขบัตรประจำตัว" => "1001670023001",
                "เพศ" => "ชาย",
                "วันเกิด" => "1985-05-12",
                "วันออกเล่มพาส" => "2016-05-01",
                "วันหมด VISA" => "2026-06-01"
            ],
            [
                "VISA_ID" => "N00893102",
                "สถานะพนักงาน" => "ทำงาน",
                "รหัสพนักงานของนายจ้าง" => "10612892",
                "สัญชาติ" => "ไต้หวัน",
                "Agency" => "บริษัท XYZ",
                "เลขบัตรประจำตัว" => "1001670023002",
                "เพศ" => "หญิง",
                "วันเกิด" => "1990-07-20",
                "วันออกเล่มพาส" => "2017-06-01",
                "วันหมด VISA" => "2026-06-05"
            ],
            // เพิ่มอีก 3 รายการได้ตามที่ให้ไว้ข้างต้น...
        ];

        return response()->json($data);
    }

    
}
