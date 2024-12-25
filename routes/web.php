<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HeadStaffController;
use App\Http\Controllers\KelolaAkunController;
use App\Http\Controllers\ResponseController;
use Illuminate\Support\Facades\Route;


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
    return view('login');
})->name('login');

Route::post('/loginAuth', [UserController::class, 'loginAuth'])->name('loginAuth');
Route::get('/buat-akun', [UserController::class, 'registration'])->name('registration');
Route::get('/home', [ReportController::class, 'index'])->name('index');
Route::get('/home/create', [ReportController::class, 'create'])->name('create');
Route::post('/home/create/store', [ReportController::class, 'store'])->name('store');
Route::get('/tampilan-artikel', [ReportController::class, 'artikel'])->name('artikel');
Route::get('/reports-search', [ReportController::class, 'searchByProvince'])->name('searchByProvince');
Route::get('/show/{id}', [ReportController::class, 'show'])->name('show');
Route::delete('/delete/{id}', [ReportController::class, 'destroy'])->name('delete');
// Route::post('/reports/vote/{id}', [ReportController::class, 'vote'])->name('reports.vote');
Route::post('/views{id}', [ReportController::class, 'views'])->name('views');
Route::post('/vote/{id}', [ReportController::class, 'vote'])->name('vote');
Route::get('/monitoring', [ReportController::class, 'dashboard'])->name('monitoring');
Route::get('/download', [ReportController::class, 'exportExcel'])->name('download');

Route::post('/store/{id}', [CommentController::class, 'store'])->name('store.comment');
Route::get('/data-staff', [ResponseController::class, 'index'])->name('data.staff');
Route::post('/pengaduan/store/{id}', [ResponseController::class, 'store'])->name('store.response');
Route::get('/pengaduan/show/{id}', [ResponseController::class, 'show'])->name('show.pengaduan');
Route::post('/pengaduan/progress/{id}', [ResponseController::class, 'storeProgress'])->name('storeProgress');
Route::put('/pengaduan/update/{id}', [ResponseController::class, 'updateStatus'])->name('update');
// Route::get('/dashboard', [ReportController::class, 'headstaffDashboard'])->name('hs.dashboard');

Route::get('/data', [KelolaAkunController::class, 'index'])->name('data');
Route::get('/tambah-akun', [KelolaAkunController::class, 'create'])->name('tambah');
Route::post('/tambah-akun/store', [KelolaAkunController::class, 'store'])->name('tambah.akun');
Route::delete('/hapus/{id}', [KelolaAkunController::class,'destroy'])->name('hapus');
Route::post('/reset/{id}', [KelolaAkunController::class, 'resetPassword'])->name('reset.password');


Route::get('/reportsbyProvince', [HeadStaffController::class, 'getReportsByProvince'])->name('report.by.province');
Route::get('/headstaff/home', [HeadStaffController::class, 'index'])->name('hs.home');