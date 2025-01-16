<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ActivityController;

/*
|---------------------------------------------------------------------- 
| Web Routes 
|---------------------------------------------------------------------- 
| 
| Definisikan semua rute aplikasi Anda di sini. 
| 
*/

// Halaman login dan register
// Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [AuthController::class, 'register']);
// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
// Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Halaman dashboard yang hanya bisa diakses oleh pengguna yang terautentikasi
Route::get('/', [DashboardController::class, 'index']);//->middleware('auth');

// Rute untuk manajemen pengguna
Route::resource('users', UserController::class);//->middleware('auth');

// Rute untuk manajemen roles
Route::resource('roles', RoleController::class);//->middleware('auth');
Route::post('roles/{role}/add-user', [RoleController::class, 'addUserToRole'])->name('roles.addUser');
Route::post('roles/{role}/remove-user', [RoleController::class, 'removeUserFromRole'])->name('roles.removeUser');

// Rute untuk manajemen grup
Route::resource('groups', GroupController::class);//->middleware('auth');

// Rute untuk manajemen member
Route::resource('members', MemberController::class);//->middleware('auth');

// Rute untuk manajemen activities
Route::resource('activities', ActivityController::class);//->middleware('auth');

