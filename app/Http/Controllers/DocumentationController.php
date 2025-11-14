<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userManual()
    {
        return view('documentation.user-manual');
    }

    public function adminGuide() 
    {
        return view('documentation.admin-guide');
    }

    public function systemOverview()
    {
        return view('documentation.system-overview');
    }
}