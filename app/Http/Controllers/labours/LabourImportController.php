<?php

namespace App\Http\Controllers\labours;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\TokenService;

class LabourImportController extends Controller
{
   public function index()
{
    $token = env('LABOUR_API_TOKEN') ?: TokenService::fetchAndStoreToken();

    $response = Http::withToken($token)
        ->get('https://thailaborland.com/api/getuserpass');

    if ($response->status() === 401) {
        $token = TokenService::fetchAndStoreToken();
        $response = Http::withToken($token)
            ->get('https://thailaborland.com/api/getuserpass');
    }

    $all = $response->json();

    // ป้องกัน error กรณี response ไม่ใช่ array หรือไม่มี key ที่ต้องการ
    if (is_array($all) && isset($all[0])) {
        $labours = $all;
    } elseif (is_array($all) && isset($all['data']) && is_array($all['data'])) {
        $labours = $all['data'];
    } else {
        $labours = [];
    }

    return view('labourImport.index', compact('labours'));
}
}
