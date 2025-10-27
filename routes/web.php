<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LabourApiController;
use App\Http\Controllers\labours\labourController;
use App\Http\Controllers\employee\employeeController;
use App\Http\Controllers\customers\CustomerController;
use App\Http\Controllers\assets\AssetAccountController;
use App\Http\Controllers\globalsets\GlobalSetController;
use App\Http\Controllers\labours\LabourImportController;
use App\Http\Controllers\labours\LabourReportController;
use App\Http\Controllers\managedocs\manageDocsController;
use App\Http\Controllers\customers\CustomerFileController;
use App\Http\Controllers\labours\ImportLabourController;
use App\Http\Controllers\labours\labourUploadfilesController;
use App\Http\Controllers\labours\labourUploadImageProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/layout/new', function () {
    return view('layouts.template-new');
});
Route::get('/layout/new/modern', function () {
    return view('layouts.template-modern-alt');
});


Auth::routes();

// Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::resources([
    'roles' => RoleController::class,
    'users' => UserController::class,
    'products' => ProductController::class,
]);

//labour
Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('home');
Route::get('/home', [\App\Http\Controllers\DashboardController::class, 'index'])->name('home');

// Dashboard Routes
Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('index');
    Route::get('/notification-details', [\App\Http\Controllers\DashboardController::class, 'viewNotificationDetails'])->name('notification-details');
    Route::get('/export-notification', [\App\Http\Controllers\DashboardController::class, 'exportNotification'])->name('export-notification');
    Route::get('/statistic-details', [\App\Http\Controllers\DashboardController::class, 'viewStatisticDetails'])->name('statistic-details');
    Route::get('/export-statistic', [\App\Http\Controllers\DashboardController::class, 'exportStatistic'])->name('export-statistic');
});

Route::get('/labours-list', [labourController::class, 'index'])->name('labours.list');
Route::resource('labours', labourController::class);
Route::get('/labours/{labour_id}/print-cv', [labourController::class, 'printCV'])->name('labours.print-cv');
Route::prefix('labours/api')->group(function () {
    Route::get('/data',        [labourController::class, 'data'])->name('labours.data');   
});
//upload image profile 
Route::middleware(['auth', 'verified'])   // ถ้าใช้ Laravel Breeze/Jetstream
      ->post('/labours/{labour}/image-profile', [labourUploadImageProfileController::class, 'uploadImage'])
      ->name('labours.upload-image');

// labour Reports
Route::prefix('report/labours')->name('report.labours.')->group(function () {
    Route::get('/',             [LabourReportController::class, 'index'])->name('index');
    Route::get('/export',       [LabourReportController::class, 'export'])->name('export');
});




Route::resource('managedocs', manageDocsController::class);

/// global
Route::get('/global-sets', [GlobalSetController::class, 'index'])->name('global-sets.index');
Route::post('/global-sets', [GlobalSetController::class, 'store'])->name('global-sets.store');
Route::put('/global-sets/{globalSet}', [GlobalSetController::class, 'update'])->name('global-sets.update');
Route::delete('/global-sets/{globalSet}', [GlobalSetController::class, 'destroy'])->name('global-sets.destroy');

//customer
Route::resource('customers', CustomerController::class);
Route::get('/customer-files/{id}', [CustomerFileController::class, 'show'])->name('customer_files.show');


//import
// Import Labour Routes
Route::prefix('import-labours')->name('import-labours.')->group(function () {
    Route::get('/', [ImportLabourController::class, 'index'])->name('index');
    Route::post('/convert/{id}', [ImportLabourController::class, 'convert'])->name('convert');
    Route::post('/test-convert/{id?}', [ImportLabourController::class, 'testConvert'])->name('test-convert');
    Route::post('/debug-convert/{id}', [ImportLabourController::class, 'debugConvert'])->name('debug-convert');
});

// Legacy route (keep for backward compatibility)
Route::get('/labour-import', [LabourImportController::class, 'index']);

Route::get('mock-labours', [LabourApiController::class, 'getMockData']);
Route::post('labours/{labour}/list-files', [\App\Http\Controllers\labours\labourController::class, 'addListFile'])->name('labours.list-files.store');
Route::get('labours/{labour}/list-files/{list_file}', [\App\Http\Controllers\labours\labourController::class, 'deleteListFile'])->name('labours.list-files.destroy');




