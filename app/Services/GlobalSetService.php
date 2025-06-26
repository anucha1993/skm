<?php

namespace App\Services;

use App\Models\globalsets\GlobalSetValueModel;
use App\Models\globalsets\GlobalSetModel;

class GlobalSetService
{
    /**
     * ค้นหาหรือสร้าง Global Set Value
     */
    public static function findOrCreateValue($globalSetId, $value)
    {
        if (empty($value)) {
            return null;
        }

        // หาค่าที่มีอยู่แล้ว
        $existingValue = GlobalSetValueModel::where('global_set_id', $globalSetId)
            ->where('value', $value)
            ->first();

        if ($existingValue) {
            return $existingValue->id;
        }

        // สร้างค่าใหม่ถ้าไม่มี
        $newValue = GlobalSetValueModel::create([
            'global_set_id' => $globalSetId,
            'value' => $value
        ]);

        return $newValue->id;
    }

    /**
     * ดึง Global Set ทั้งหมดที่ใช้ในระบบ
     */
    public static function getSystemGlobalSets()
    {
        return [
            'hospital' => 1,        // โรงพยาบาล
            'examination_center' => 2, // ศูนย์สอบ
            'country' => 3,         // ประเทศ
            'job_group' => 4,       // กลุ่มงาน
            'position' => 5,        // ตำแหน่ง
            'status' => 6,          // สถานะ
            'staff' => 7,           // เจ้าหน้าที่
            'staff_sub' => 8,       // เจ้าหน้าที่สาย
            'skill' => 9,           // ทักษะ/ความสามารถ
            'education_level' => 10, // ระดับการศึกษา
            'language' => 11,       // ภาษา
        ];
    }

    /**
     * ตรวจสอบและสร้าง Global Set หากไม่มี
     */
    public static function ensureGlobalSetExists($globalSetId, $name, $description = null)
    {
        $globalSet = GlobalSetModel::find($globalSetId);
        
        if (!$globalSet) {
            $globalSet = GlobalSetModel::create([
                'id' => $globalSetId,
                'name' => $name,
                'description' => $description,
                'sort_order_preference' => 'entered'
            ]);
        }

        return $globalSet;
    }

    /**
     * สร้าง Global Sets เริ่มต้นที่จำเป็น
     */
    public static function createDefaultGlobalSets()
    {
        $sets = [
            ['id' => 1, 'name' => 'โรงพยาบาล', 'description' => 'รายชื่อโรงพยาบาลที่ใช้ตรวจสุขภาพ'],
            ['id' => 2, 'name' => 'ศูนย์สอบ', 'description' => 'ศูนย์สอบแรงงานต่างด้าว'],
            ['id' => 3, 'name' => 'ประเทศ', 'description' => 'ประเทศต้นทางของแรงงาน'],
            ['id' => 4, 'name' => 'กลุ่มงาน', 'description' => 'ประเภทงานที่แรงงานทำ'],
            ['id' => 5, 'name' => 'ตำแหน่งงาน', 'description' => 'ตำแหน่งงานเฉพาะ'],
            ['id' => 6, 'name' => 'สถานะแรงงาน', 'description' => 'สถานะการดำเนินการของแรงงาน'],
            ['id' => 7, 'name' => 'เจ้าหน้าที่สรรหา', 'description' => 'เจ้าหน้าที่ที่รับผิดชอบ'],
            ['id' => 8, 'name' => 'สายงานเจ้าหน้าที่', 'description' => 'สายงานของเจ้าหน้าที่'],
            ['id' => 9, 'name' => 'ทักษะความสามารถ', 'description' => 'ทักษะและความสามารถของแรงงาน'],
            ['id' => 10, 'name' => 'ระดับการศึกษา', 'description' => 'ระดับการศึกษาของแรงงาน'],
            ['id' => 11, 'name' => 'ภาษา', 'description' => 'ภาษาที่แรงงานใช้ได้'],
        ];

        foreach ($sets as $set) {
            self::ensureGlobalSetExists($set['id'], $set['name'], $set['description']);
        }
    }

    /**
     * สร้างค่าเริ่มต้นสำหรับสถานะ
     */
    public static function createDefaultStatuses()
    {
        $defaultStatuses = [
            'รอดำเนินการ',
            'กำลังดำเนินการ', 
            'ดำเนินการเสร็จ',
            'ยกเลิก'
        ];

        foreach ($defaultStatuses as $status) {
            self::findOrCreateValue(6, $status); // 6 = สถานะแรงงาน
        }
    }
}
