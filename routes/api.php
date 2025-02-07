<?php

use App\Http\Controllers\DashboardApiController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\UserApiController;

// Route::middleware(['web'])->group(function () {
    Route::post('/login', [AuthApiController::class, 'login'])->name('api.login');
    // Route::post('/logout', [AuthApiController::class, 'logout'])->name('api.logout');
// });
// Route::post('login', [AuthApiController::class, 'login'])->name('api.login');
Route::post('register', [AuthApiController::class, 'register']);


// use App\Http\Controllers\DashboardController;
// use App\Http\Controllers\UserController;
// use App\Http\Controllers\AuthController;
// use App\Http\Controllers\RoleController;
// use App\Http\Controllers\GroupController;
// use App\Http\Controllers\MemberController;
// use App\Http\Controllers\ActivityController;
// use App\Http\Controllers\UserActivityController;

// /*
// |--------------------------------------------------------------------------
// | API Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register API routes for your application. These
// | routes are loaded by the RouteServiceProvider within a group which
// | is assigned the "api" middleware group. Enjoy building your API!
// |
// */

// Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/home', [HomeController::class, 'index'])->name('home');

// // Authentication routes
// // Route::middleware('guest')->group(function () {
//     Route::post('/login', [AuthController::class, 'login']);
// // });

Route::middleware('auth:sanctum')->group(function () {
        Route::get('/dashboard', [DashboardApiController::class, 'index'])->name('api.dashboard');
        Route::post('/logout', [AuthApiController::class, 'logout'])->name('logout');
        Route::prefix('users')->group(function () {
            Route::get('/', [UserApiController::class, 'index'])->name('api.users.index');
            Route::get('/create', [UserApiController::class, 'create'])->name('api.users.create');
            Route::get('/{id}', [UserApiController::class, 'show'])->name('api.users.show');
            Route::get('/{id}/edit', [UserApiController::class, 'edit'])->name('users.edit');
            Route::post('/', [UserApiController::class, 'store'])->name('api.users.store');
            Route::put('/{id}', [UserApiController::class, 'update'])->name('api.users.update');
            Route::delete('/{id}', [UserApiController::class, 'destroy'])->name('api.users.destroy');
        });
    });

//         // Dashboard route
//         Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//         // User management routes
//         Route::apiResource('users', UserController::class);

//         // Role management routes
//         Route::apiResource('roles', RoleController::class);
//         Route::post('roles/{role}/add-user', [RoleController::class, 'addUserToRole'])->name('roles.addUser');
//         Route::post('/roles/{role}/update-user-role', [RoleController::class, 'updateUserRole'])->name('roles.updateUserRole');

//         // Group management routes
//         Route::apiResource('groups', GroupController::class);
//         Route::get('/groups-by-user', [GroupController::class, 'getGroupsByUserId'])->name('groups.byUser');

//         // Member management routes
//         Route::apiResource('members', MemberController::class);

//         // Activity management routes
//         Route::apiResource('activities', ActivityController::class);
//         Route::apiResource('userActivities', UserActivityController::class);
    // });
