<?php

namespace App\Http\Controllers\labours;

use Illuminate\View\View;
use Illuminate\Http\Request;

use App\Models\customers\Customer;
use App\Models\labours\labourModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\globalsets\GlobalSetModel;
use App\Models\labours\listfilesModel;
use App\Models\managedocs\managedocsModel;
use App\Models\managedocs\managefilesModel;

class labourController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('labours.index');
    }

    public function data()
    {
        $fallback = asset('images/user_icon.png'); // <<— รูป default

        $labours = LabourModel::select(['labour_id', 'labour_prefix', 'labour_firstname', 'labour_lastname', 'labour_phone_one', 'labour_image_thumbnail_path as thumbnail'])
            ->orderByDesc('labour_id')
            ->get()
            ->map(function ($row) use ($fallback) {
                $row->thumbnail = $row->thumbnail ? asset('storage/' . ltrim($row->thumbnail, '/')) : $fallback;
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
        $listFiles = listfilesModel::where('labour_id',$labour->labour_id)->get();

        return view('labours.edit', compact('listFiles','labour', 'customers', 'StaffsubGlobalSet', 'StaffGlobalSet', 'ExaminationCenterGlobalSet', 'hospitalGlobalSet', 'manageDocs', 'countryGlobalSet', 'jobGroupGlobalSet', 'positionGlobalSet', 'statusGlobalSet'));
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
                    'file_path' => NULL,
                ]);
            }
        }

        $labour->update($request->all());

    }

    public function store(Request $request)
    {
        //dd($request);
        $request->merge(['created_by' => Auth::user()->name]);
        $labours = labourModel::create($request->all());
    }
}
