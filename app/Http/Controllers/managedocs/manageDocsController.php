<?php

namespace App\Http\Controllers\managedocs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\category\countryJobModel;
use App\Models\managedocs\managedocsModel;
use App\Models\managedocs\managefilesModel;

class manageDocsController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-managedoc|edit-managedoc|delete-managedoc', ['only' => ['index','show']]);
        $this->middleware('permission:create-managedoc', ['only' => ['create','store']]);
        $this->middleware('permission:edit-managedoc', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-managedoc', ['only' => ['destroy']]);
    }


    public function index(Request $request)
    {
        $managedocs = managedocsModel::latest()->get();
        return view('managedocs.index',compact('managedocs'));
    }

    public function create()
    {
        $country = countryJobModel::latest()->get();
        return view('managedocs.create',compact('country'));
    }

    public function store(Request $request)
    {
        //dd($request);

        $managedoc = managedocsModel::create($request->all());
        
        foreach ($request->managefile_no as $key => $item)
        {
            managefilesModel::create([
                'managefile_no' =>$request->managefile_no[$key],
                'managefile_code' =>$request->managefile_code[$key],
                'managefile_name' =>$request->managefile_name[$key],
                'managefile_step' =>$request->managefile_step[$key],
                'managefile_status' =>$request->managefile_status[$key],
                'managedoc_id' =>$managedoc->managedoc_id,
            ]);
        }
    }
}
