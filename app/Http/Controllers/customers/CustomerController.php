<?php

namespace App\Http\Controllers\customers;

use Log;
use Illuminate\Http\Request;
use App\Models\customers\Customer;
use App\Http\Controllers\Controller;
use App\Models\customers\CustomerFile;
use Illuminate\Support\Facades\Storage;
use App\Models\globalsets\GlobalSetModel;

class CustomerController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth');
       $this->middleware('permission:create-customer|edit-product|delete-customer', ['only' => ['index','show']]);
       $this->middleware('permission:create-customer', ['only' => ['create','store']]);
       $this->middleware('permission:edit-customer', ['only' => ['edit','update']]);
       $this->middleware('permission:delete-customer', ['only' => ['destroy']]);
    }

    // แสดงรายการลูกค้าทั้งหมด
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('customers.index', compact('customers'));
    }

    // แสดงฟอร์มสร้างลูกค้าใหม่
    public function create()
    {
        $countryGlobalSet = GlobalSetModel::with('values')->where('id', 3)->first();
        return view('customers.create', compact('countryGlobalSet'));
    }

    // แสดงรายละเอียดลูกค้า
    public function show(Customer $customer)
    {
        $countryGlobalSet = GlobalSetModel::with('values')->where('id', 3)->first();
        return view('customers.show', compact('customer', 'countryGlobalSet'));
    }

    // บันทึกข้อมูลลูกค้าใหม่พร้อมกับไฟล์แนบ (ถ้ามี)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'status' => 'required|in:disabled,active',
            'notes' => 'nullable|string',
            'files.*' => 'nullable|file|max:2048', // จำกัดขนาดไฟล์แต่ละไฟล์ 2MB
        ]);

        // สร้างลูกค้าใหม่
        $customer = Customer::create([
            'name' => $request->name,
            'country' => $request->country,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

       // กำหนดโฟลเดอร์ที่ต้องการเก็บไฟล์ (ในที่นี้คือ storage/app/customer_files)
$destinationPath = storage_path('app/customer_files');

// ตรวจสอบว่าโฟลเดอร์มีอยู่แล้วหรือไม่ ถ้าไม่มีให้สร้างขึ้น
if (!is_dir($destinationPath)) {
    mkdir($destinationPath, 0777, true);
}

if ($request->hasFile('files')) {
    foreach ($request->file('files') as $file) {
        // ตรวจสอบว่าไฟล์ถูก upload อย่างถูกต้องหรือไม่
        if ($file->isValid()) {
            // สร้างชื่อไฟล์ที่ไม่ซ้ำกัน โดยสามารถใช้ timestamp ควบคู่กับชื่อไฟล์เดิม
            $fileName = time() . '_' . $file->getClientOriginalName();
            // ใช้ move() เพื่อย้ายไฟล์ไปยัง storage/app/customer_files
            $file->move($destinationPath, $fileName);

            // บันทึกข้อมูลลงในฐานข้อมูล โดยเก็บ path แบบ relative (เช่น customer_files/filename.ext)
            CustomerFile::create([
                'customer_id'        => $customer->id,
                'file_path'          => 'customer_files/' . $fileName,
                'file_original_name' => $file->getClientOriginalName(),
            ]);
        } else {
            // log error ถ้าไฟล์ไม่ valid
            \Log::error('Invalid file detected during upload.');
        }
    }
}

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    // แสดงฟอร์มแก้ไขข้อมูลลูกค้า
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    // อัปเดตข้อมูลลูกค้า (และอัปโหลดไฟล์เพิ่ม ถ้ามี)
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'status' => 'required|in:disabled,active',
            'notes' => 'nullable|string',
            'files.*' => 'nullable|file|max:2048',
        ]);

        // อัปเดตข้อมูลลูกค้า
        $customer->update([
            'name' => $request->name,
            'country' => $request->country,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        // หากมีการอัพโหลดไฟล์ใหม่ ให้ loop และบันทึกเพิ่ม
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('customer_files');
                CustomerFile::create([
                    'customer_id' => $customer->id,
                    'file_path' => $path,
                    'file_original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    // ลบลูกค้าและไฟล์แนบทั้งหมด (เนื่องจากใช้ onDelete cascade)
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }


}
