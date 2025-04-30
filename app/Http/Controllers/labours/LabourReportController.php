<?php

namespace App\Http\Controllers\labours;

use Illuminate\Http\Request;
use App\Exports\LaboursExport;
use App\Models\customers\Customer;
use App\Models\labours\labourModel;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\globalsets\GlobalSetValueModel;
use App\Models\labours\listfilesModel;


class LabourReportController extends Controller
{
    //
     // 3.1 แสดงฟอร์ม + ตาราง preview (ถ้าต้องการ)
     public function index(Request $request)
     {
         $filters = $request->only(['company_id','labour_status','country_id','date_from','date_to','steps']);
 
         $companies = Customer::orderBy('name')->get();
         $statuses  = GlobalSetValueModel::where('global_set_id',6)->get();      // ตัวอย่าง group-id
         $countries = GlobalSetValueModel::where('global_set_id',3)->get();
 
         // ตาราง preview 20 แถวแรก
         $preview = labourModel::with(['company','country','position','jobGroup'])
         ->filter($filters)          // <-- ใช้ scope ที่สร้าง
         ->latest()
         ->limit(20)
         ->get();

         $allSteps = ListFilesModel::distinct()
         ->orderBy('managefile_step')
         ->pluck('managefile_step');   // ใช้เติม dropdown
 
         return view('reports.labours.index', compact('filters','companies','statuses','countries','preview','allSteps'));
     }
 
     // 3.2 ส่งออก Excel
     public function export(Request $request)
     {
         $filters = $request->all();
         $fileName = 'labours_'.now()->format('Ymd_His').'.xlsx';
 
         return Excel::download(new LaboursExport($filters), $fileName);
     }
}
