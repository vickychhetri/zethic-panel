<?php

use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\EmployeeController;
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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [UserAuthController::class, 'showLoginForm'])->name('login');
Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserAuthController::class, 'login']);


Route::middleware(['auth','prevent-history'])->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminHomeController::class, 'dashboard'])->name('admin.dashboard');
    Route::any('logout', [UserAuthController::class, 'logout'])->name('admin.logout');
    Route::get('dashboard', [AdminHomeController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('employee', EmployeeController::class);
});


