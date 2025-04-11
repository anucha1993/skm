<?php

namespace App\Http\Controllers\customers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\customers\CustomerFile;

class CustomerFileController extends Controller
{
    //
    public function show($id)
    {
        // ค้นหาไฟล์จากฐานข้อมูล
        $customerFile = CustomerFile::findOrFail($id);

        // สร้าง full path ของไฟล์ใน storage (สมมุติว่าไฟล์ถูกเก็บอยู่ใน storage/app)
        $filePath = storage_path('app/' . $customerFile->file_path);

        // ตรวจสอบว่ามีไฟล์จริงหรือไม่
        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        // หากต้องการแสดงผลไฟล์ใน browser (เช่น ภาพหรือ PDF)
        return response()->file($filePath);
        
        // หากต้องการดาวน์โหลดไฟล์ ให้ใช้:
        // return response()->download($filePath, $customerFile->file_original_name);
    }
}
