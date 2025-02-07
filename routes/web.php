<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

// Route::middleware(['web'])->group(function () {
//     Route::post('/login', [AuthApiController::class, 'login'])->name('api.login');
// });

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\GroupController;
// use App\Http\Controllers\MemberController;
// use App\Http\Controllers\ActivityController;
// use App\Http\Controllers\UserActivityController;

// // /*
// // |---------------------------------------------------------------------- 
// // | Web Routes 
// // |---------------------------------------------------------------------- 
// // | 
// // | Definisikan semua rute aplikasi Anda di sini. 
// // | 
// // */



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// // Halaman login dan register
// Route::middleware('guest')->group(function () {
//     Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
//     Route::post('/login', [AuthController::class, 'login']);
//     Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
//     Route::post('/register', [AuthController::class, 'register']);
// });

// // Rute logout
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// // Halaman dashboard (hanya untuk pengguna yang sudah login)

// Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute untuk manajemen pengguna
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    });
    Route::prefix('roles')->group(function (){
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
        Route::get('/{id}', [RoleController::class, 'show'])->name('roles.show');
        Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    });

    

    // Rute untuk manajemen roles
    

//     Route::resource('roles', RoleController::class);
//     Route::post('roles/{role}/add-user', [RoleController::class, 'addUserToRole'])->name('roles.addUser');
//     // Route::post('roles/{role}/remove-user', [RoleController::class, 'removeUserFromRole'])->name('roles.removeUser');
//     Route::post('/roles/{role}/update-user-role', [RoleController::class, 'updateUserRole'])->name('roles.updateUserRole');


//     // Rute untuk manajemen grup
//     Route::resource('groups', GroupController::class);
//     // web.php
//     // Route::get('/users/{user}/groups', [UserController::class, 'getUserGroups']);
//     Route::get('/groups-by-user', [GroupController::class, 'getGroupsByUserId'])->name('groups.byUser');


//     // Rute untuk manajemen member
//     Route::resource('members', MemberController::class);

//     // Rute untuk manajemen activities
//     Route::resource('activities', ActivityController::class);
//     Route::resource('userActivities', UserActivityController::class);
});
