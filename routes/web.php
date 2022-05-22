<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsersAdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketUserController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\TechnicianTicketController;

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

// Login - Regist
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('loginAttempt', [LoginController::class, 'loginAttempt'])->name('loginAttempt');
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'admin', 'revalidate'])->group(function () {
    // Admin
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::resource('admin/users', UsersAdminController::class);
});

Route::middleware(['auth', 'user', 'revalidate'])->group(function () {
    // User
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::resource('user/tickets', TicketUserController::class);
});

Route::middleware(['auth', 'technician', 'revalidate'])->group(function () {
    // Technician
    Route::get('/technician', [TechnicianController::class, 'index'])->name('technician');
    Route::resource('technician/ticket', TechnicianTicketController::class);
});

