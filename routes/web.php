<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserActivityController;

// /*
// |---------------------------------------------------------------------- 
// | Web Routes 
// |---------------------------------------------------------------------- 
// | 
// | Definisikan semua rute aplikasi Anda di sini. 
// | 
// */



Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman login dan register
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Rute logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Halaman dashboard (hanya untuk pengguna yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute untuk manajemen pengguna
    Route::resource('users', UserController::class);

    // Rute untuk manajemen roles
    Route::resource('roles', RoleController::class);
    Route::post('roles/{role}/add-user', [RoleController::class, 'addUserToRole'])->name('roles.addUser');
    // Route::post('roles/{role}/remove-user', [RoleController::class, 'removeUserFromRole'])->name('roles.removeUser');
    Route::post('/roles/{role}/update-user-role', [RoleController::class, 'updateUserRole'])->name('roles.updateUserRole');


    // Rute untuk manajemen grup
    Route::resource('groups', GroupController::class);
    // web.php
    // Route::get('/users/{user}/groups', [UserController::class, 'getUserGroups']);
    Route::get('/groups-by-user', [GroupController::class, 'getGroupsByUserId'])->name('groups.byUser');


    // Rute untuk manajemen member
    Route::resource('members', MemberController::class);

    // Rute untuk manajemen activities
    Route::resource('activities', ActivityController::class);
    Route::resource('userActivities', UserActivityController::class);
});
