<?php

use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/ismail', [App\Http\Controllers\TestPhpMailerController::class, 'index'])->name('ismail');
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});
Route::get('/migrate99', function() {
    Artisan::call('migrate');
    return 'DONE'; //Return anything
});
Route::get('/emmaill', function () {
   Mail::raw('Message text', function($message) {
    $message->to('azizmsn175@gmail.com');
});
    return 'Terkirim';
});
Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['verify' => true, 'register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/get-current-divisi', [App\Http\Controllers\AjaxController::class, 'getcurrentdivisi'])->name('ajax.getcurrentdivisi');
Route::post('/get-divisi-from-institusi', [App\Http\Controllers\AjaxController::class, 'getdivisifrominstitusi'])->name('ajax.getdivisifrominstitusi');
Route::post('/get-leader-from-divisi', [App\Http\Controllers\AjaxController::class, 'getleaderfromdivisi'])->name('ajax.getleaderfromdivisi');
Route::post('/get-leader-from-institusi', [App\Http\Controllers\AjaxController::class, 'getleaderfrominstitusi'])->name('ajax.getleaderfrominstitusi');
Route::resource('user', 'App\Http\Controllers\UserController');
Route::resource('employee', 'App\Http\Controllers\EmployeeController');
Route::get('leader/{leader_id}/employee',  [App\Http\Controllers\EmployeeController::class, 'employee_index'])->name('leader_employee.index');
Route::get('leader/{leader_id}/employee/tambah',  [App\Http\Controllers\EmployeeController::class, 'employee_create'])->name('leader_employee.create');
Route::get('leader/{leader_id}/employee/select',  [App\Http\Controllers\EmployeeController::class, 'employee_select'])->name('leader_employee.select');
Route::resource('institusi', 'App\Http\Controllers\InstitusiController');
Route::get('institusi/{institusi_id}/divisi',  [App\Http\Controllers\DivisiController::class, 'divisi_index'])->name('institusi_divisi.index');
Route::get('institusi/{institusi_id}/divisi/tambah',  [App\Http\Controllers\DivisiController::class, 'divisi_create'])->name('institusi_divisi.create');
Route::resource('divisi', 'App\Http\Controllers\DivisiController');

Route::resource('reimbursement', 'App\Http\Controllers\ReimbursementController');
Route::resource('purchase', 'App\Http\Controllers\PurchaseController');

Route::get('/purchase/detail/{id}/view', [App\Http\Controllers\PurchaseController::class, 'detail'])->name('purchase.detail');
Route::get('/purchase/detail/edit/{id}/view', [App\Http\Controllers\PurchaseController::class, 'detail_edit'])->name('purchase.detail_edit');
Route::resource('purchase-detail', 'App\Http\Controllers\PurchaseDetailController');

Route::get('/reimbursement/detail/{id}/view', [App\Http\Controllers\ReimbursementController::class, 'detail'])->name('reimbursement.detail');
Route::get('/reimbursement/detail/edit/{id}/view', [App\Http\Controllers\ReimbursementController::class, 'detail_edit'])->name('reimbursement.detail_edit');
Route::resource('reimbursement-detail', 'App\Http\Controllers\ReimbursementDetailController');

Route::resource('approval', 'App\Http\Controllers\ApprovalController');
Route::resource('approvalreimbursement', 'App\Http\Controllers\ApprovalReimbursementController');

Route::resource('history', 'App\Http\Controllers\HistoryController');
Route::resource('historyreimbursement', 'App\Http\Controllers\HistoryReimbursementController');

Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
Route::post('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

Route::get('/report/{id}', [App\Http\Controllers\ReportController::class, 'index'])->name('report.index');
Route::get('/reportreimbursement/{id}', [App\Http\Controllers\ReportReimbursementController::class, 'index'])->name('reportreimbursement.index');

