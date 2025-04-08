<?php

namespace App\Http\Controllers\labours;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class labourController extends Controller
{
    //
    public function create(): View
    {
        return view('labours.create');
    }

}
