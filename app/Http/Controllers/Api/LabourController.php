<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\labours\labourModel;

class LabourController extends Controller
{
    public function index(Request $request)
    {
        $labours = labourModel::all();
        return response()->json($labours);
    }
}
