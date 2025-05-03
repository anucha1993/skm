<?php

namespace App\Http\Controllers\labours;

use Illuminate\View\View;
use Illuminate\Http\Request;

use App\Models\customers\Customer;
use Illuminate\Support\Facades\DB;
use App\Models\labours\labourModel;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Models\labours\listfilesModel;
use App\Models\globalsets\GlobalSetModel;
use App\Models\managedocs\managedocsModel;
use App\Models\managedocs\managefilesModel;

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
        // 1) จำนวนคนงานทั้งหมด
        $totalLabours = LabourModel::count();

        $allStatus = [
            'รอดำเนินการ', // pending
            'กำลังดำเนินการ', // processing
            'ดำเนินการเสร็จ', // completed
            'ยกเลิก', // cancelled
        ];
        $statusCounts = LabourModel::with('labourStatus:value,id')->select('labour_status', DB::raw('COUNT(*) as total'))->groupBy('labour_status')->get()->mapWithKeys(fn($row) => [$row->labourStatus->value ?? 'ไม่ระบุ' => $row->total])->toArray();
        /* เติม 0 ให้สถานะที่ไม่มี */
        $statusCounts = array_replace(array_fill_keys($allStatus, 0), $statusCounts);

        return view('labours.index', compact('totalLabours', 'statusCounts'));
    }

    public function data()
    {
        $fallback = asset('images/user_icon.png');

        $labours = LabourModel::with('listFiles', 'country:id,value', 'jobGroup:id,value')
            ->select(['labour_id', 'labour_prefix', 'labour_firstname', 'labour_lastname', 'labour_phone_one', 'labour_image_thumbnail_path AS thumbnail', 'country_id', 'job_group_id'])
            ->orderByDesc('labour_id')
            ->get()
            ->map(function ($row) use ($fallback) {
                // รูป
                $row->thumbnail = $row->thumbnail ? asset('storage/' . ltrim($row->thumbnail, '/')) : $fallback;

                // ⇢ NEW ⇠  ทำ badge ของ Step
                $badges = collect(['A', 'B'])
                    ->map(function ($s) use ($row) {
                        $ok = in_array($s, $row->completed_steps);
                        $cls = $ok ? 'success' : 'secondary'; // เขียว=ครบ / เทา=ยังไม่ครบ
                        return "<span class='badge bg-{$cls}'>Step {$s}</span>";
                    })
                    ->implode(' ');

                $row->steps_badge = $badges;
                return $row;
            });

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

        return view('labours.edit', compact('listFiles', 'labour', 'customers', 'StaffsubGlobalSet', 'StaffGlobalSet', 'ExaminationCenterGlobalSet', 'hospitalGlobalSet', 'manageDocs', 'countryGlobalSet', 'jobGroupGlobalSet', 'positionGlobalSet', 'statusGlobalSet'));
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

        return view('labours.show', compact('listFiles', 'labour', 'customers', 'StaffsubGlobalSet', 'StaffGlobalSet', 'ExaminationCenterGlobalSet', 'hospitalGlobalSet', 'manageDocs', 'countryGlobalSet', 'jobGroupGlobalSet', 'positionGlobalSet', 'statusGlobalSet'));
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
        $manageDocs = managedocsModel::latest()->get();
        $customers = Customer::latest()->get();
        return view('labours.create', compact('customers', 'StaffsubGlobalSet', 'StaffGlobalSet', 'ExaminationCenterGlobalSet', 'hospitalGlobalSet', 'manageDocs', 'countryGlobalSet', 'jobGroupGlobalSet', 'positionGlobalSet', 'statusGlobalSet'));
    }

    public function update(Request $request, labourModel $labour)
    {
        $managedocNew = $request->managedoc_id;
        $managedocOld = $labour->managedoc_id;

        if ($managedocNew !== $managedocOld) {
            listfilesModel::where('managedoc_id', $managedocOld)->delete();
            $managefiles = managefilesModel::where('managedoc_id', $managedocNew)->get();
            foreach ($managefiles as $key => $item) {
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

        $labour->update($request->all());

        return redirect()->back();
    }
    
    public function store(Request $request)
    {
        // ตรวจสอบเลขบัตรประชาชนว่าซ้ำหรือไม่
        $exists = labourModel::where('labour_idcard_number', $request->labour_idcard_number)->exists();
    
        if ($exists) {
            return 'เลขบัตรประชาชนนี้มีอยู่ในระบบแล้ว';
        }
    
        // หากไม่ซ้ำ ให้ทำการเพิ่มข้อมูลใหม่
        $request->merge(['created_by' => Auth::user()->name]);
        $labours = labourModel::create($request->all());
    
        return redirect()->route('home')->with('success', 'เพิ่มข้อมูลเรียบร้อยแล้ว');
    }

    public function destroy(labourModel $labour)
    {
        
    }
    
}
