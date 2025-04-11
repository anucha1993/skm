<?php

namespace App\Http\Controllers\labours;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\globalsets\GlobalSetModel;
use App\Models\managedocs\managedocsModel;

class labourController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
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
        return view('labours.create',compact('StaffsubGlobalSet','StaffGlobalSet','ExaminationCenterGlobalSet','hospitalGlobalSet','manageDocs','countryGlobalSet','jobGroupGlobalSet','positionGlobalSet','statusGlobalSet'));
    }

}
