<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\labours\labourController;
use App\Http\Controllers\employee\employeeController;
use App\Http\Controllers\customers\CustomerController;
use App\Http\Controllers\assets\AssetAccountController;
use App\Http\Controllers\globalsets\GlobalSetController;
use App\Http\Controllers\managedocs\manageDocsController;
use App\Http\Controllers\customers\CustomerFileController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::resources([
    'roles' => RoleController::class,
    'users' => UserController::class,
    'products' => ProductController::class,
]);

//labour
Route::resource('labours', LabourController::class);
Route::resource('managedocs', manageDocsController::class);


/// global
Route::get('/global-sets', [GlobalSetController::class, 'index'])->name('global-sets.index');
Route::post('/global-sets', [GlobalSetController::class, 'store'])->name('global-sets.store');
Route::put('/global-sets/{globalSet}', [GlobalSetController::class, 'update'])->name('global-sets.update');
Route::delete('/global-sets/{globalSet}', [GlobalSetController::class, 'destroy'])->name('global-sets.destroy');

//customer
Route::resource('customers', CustomerController::class);
Route::get('/customer-files/{id}', [CustomerFileController::class, 'show'])->name('customer_files.show');


