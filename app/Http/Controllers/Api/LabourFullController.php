<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\labours\labourModel;

class LabourFullController extends Controller
{
    public function index()
    {
        $labours = labourModel::with([
            'company:id,name',
            'labourStatus:id,value',
            'country:id,value',
            'jobGroup:id,value',
            'position:id,value',
            'examinationCenter:id,value',
            'staff:id,value',
            'staffSub:id,value',
            'manageDoc:managedoc_id,managedoc_name',
            'listFiles:list_file_id,labour_id,managefile_code,managefile_name,managefile_step,file_path,updated_at',
        ])->get();

        return response()->json(['data' => $labours]);
    }
}
