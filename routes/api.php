<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LabourApiController;
use App\Http\Controllers\Api\LabourStatusController;
use App\Http\Controllers\labours\labourUploadfilesController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LabourController;
use App\Http\Controllers\Api\LabourFullController;

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

// Labour Status API Routes
Route::prefix('labour-status')->group(function () {
    Route::post('/receive', [LabourStatusController::class, 'receiveStatus'])->name('api.labour-status.receive');
    Route::get('/send/{labourId}', [LabourStatusController::class, 'sendStatus'])->name('api.labour-status.send');
});

// ⬇︎ POST สำหรับอัปโหลดไฟล์
Route::post('labours/{labour}/list-files/{listFile}', [LabourUploadfilesController::class, 'upload'])->name('labours.list-files.upload'); // <- ชื่อ route

// ⬇︎ DELETE สำหรับลบไฟล์
Route::delete('list-files/{listFile}', [LabourUploadfilesController::class, 'destroy'])->name('labours.list-files.destroy');

// route ดู / ดาวน์โหลด (ใช้ GET)
Route::get('list-files/{listFile}/download', [LabourUploadfilesController::class, 'download'])->name('labours.list-files.download');

// route สำหรับดู PDF ใน browser
Route::get('list-files/{listFile}/view-pdf', [LabourUploadfilesController::class, 'viewPdf'])->name('labours.list-files.view-pdf');

// route สำหรับ PDF viewer พร้อม PDF.js
Route::get('list-files/{listFile}/pdf-viewer', [LabourUploadfilesController::class, 'pdfViewer'])->name('labours.list-files.pdf-viewer');

Route::post('/token', [AuthController::class, 'getToken']);
Route::middleware(['check.api.token'])->get('/labours', [LabourController::class, 'index']);
Route::middleware(['check.api.token'])->get('/labours-full', [LabourFullController::class, 'index']);



