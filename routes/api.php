<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\labours\labourUploadfilesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ⬇︎ POST สำหรับอัปโหลดไฟล์
Route::post('labours/{labour}/list-files/{listFile}', [LabourUploadfilesController::class, 'upload'])->name('labours.list-files.upload'); // <- ชื่อ route

// ⬇︎ DELETE สำหรับลบไฟล์
Route::delete('list-files/{listFile}', [LabourUploadfilesController::class, 'destroy'])->name('labours.list-files.destroy');
// route ดู / ดาวน์โหลด (ใช้ GET)
Route::get('list-files/{listFile}/download', [LabourUploadfilesController::class, 'download'])->name('labours.list-files.download');
