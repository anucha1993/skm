<?php

namespace App\Http\Controllers\globalsets;

use App\Http\Controllers\Controller;
use App\Models\globalsets\GlobalSetModel;
use App\Models\globalsets\GlobalSetValueModel;
use Illuminate\Http\Request;

class GlobalSetController extends Controller
{
    //
     /**
     * แสดงรายการ Global Set ทั้งหมด
     */
    public function index()
    {
        $globalSets = GlobalSetModel::orderBy('id', 'desc')->get();
        return view('global_sets.index', compact('globalSets'));
    }

    /**
     * สร้าง Global Set ใหม่
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'description'           => 'nullable|string',
            'sort_order_preference' => 'required|in:entered,alphabetical',
            'values'                => 'array', // ต้องการเช็คว่าค่าเป็น array หรือไม่
        ]);

        $globalSet = GlobalSetModel::create([
            'name'                  => $request->name,
            'description'           => $request->description,
            'sort_order_preference' => $request->sort_order_preference,
        ]);

        // ถ้ามี values ที่ส่งมา ให้ทำการบันทึก
        if ($request->has('values')) {
            foreach ($request->values as $value) {
                GlobalSetValueModel::create([
                    'global_set_id' => $globalSet->id,
                    'value'         => $value,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Global Set has been created.');
    }

    /**
     * แก้ไข Global Set (ส่วนใหญ่จะใช้ AJAX + Modal)
     */
    public function update(Request $request, GlobalSetModel $globalSet)
    {
        // Validate input ตามที่ต้องการ
        $request->validate([
            'name'                  => 'required|string|max:255',
            'description'           => 'nullable|string',
            'sort_order_preference' => 'required|in:entered,alphabetical',
            'values'                => 'array',
        ]);
    
        // อัปเดตข้อมูล GlobalSet หลักก่อน
        $globalSet->update([
            'name'                  => $request->name,
            'description'           => $request->description,
            'sort_order_preference' => $request->sort_order_preference,
        ]);
    
        // ดึงรายการ GlobalSetValue ที่มีอยู่จากฐานข้อมูลออกมาเป็น array ของ id
        $existingIds = $globalSet->values()->pluck('id')->toArray();
        $submittedIds = [];
    
        // Loop ผ่านข้อมูลที่ส่งมาจากฟอร์ม (แต่ละ record ควรเป็น array ที่มี key 'value' และ (ถ้ามี) 'id')
        foreach ($request->values as $item) {
            // ตรวจสอบว่า $item เป็น array หรือไม่ (ในกรณีบาง fieldอาจจะส่งมาเป็น string ให้ fallback)
            if (!is_array($item)) {
                $item = ['value' => $item];
            }
    
            if (isset($item['id']) && !empty($item['id'])) {
                // ถ้า key id ถูกส่งมา ให้ทำการ Update รายการเดิม
                $globalSetValue = GlobalSetValueModel::find($item['id']);
                if ($globalSetValue) {
                    $globalSetValue->update([
                        'value' => $item['value']
                    ]);
                    $submittedIds[] = $item['id'];
                }
            } else {
                // ถ้าไม่มี key id นั่นคือรายการใหม่ ให้ทำการสร้างใหม่
                $newRecord = GlobalSetValueModel::create([
                    'global_set_id' => $globalSet->id,
                    'value'         => $item['value'],
                ]);
                $submittedIds[] = $newRecord->id;
            }
        }
    
        // ส่วนลบรายการที่ถูกเอาออกไปจากฟอร์ม (หากมีการลบรายการใด ๆ)
        $idsToDelete = array_diff($existingIds, $submittedIds);
        if (!empty($idsToDelete)) {
            GlobalSetValueModel::whereIn('id', $idsToDelete)->delete();
        }
    
        return redirect()->back()->with('success', 'Global Set has been updated.');
    }
    

    /**
     * ลบ Global Set
     */
    public function destroy(GlobalSetModel $globalSet)
    {
        $globalSet->delete();
        return redirect()->back()->with('success', 'Global Set has been deleted.');
    }
}
