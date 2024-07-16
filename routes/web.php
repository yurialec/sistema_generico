<?php

use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [SiteController::class, 'index']);

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::prefix('admin/')->group(function () {
        Route::get('home', [HomeController::class, 'index'])->name('home');
        Route::get('menus', [MenuController::class, 'index'])->name('menus');

        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('users.index');
            Route::get('/list', [UserController::class, 'list'])->name('users.list');
            Route::get('/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/store', [UserController::class, 'store'])->name('users.store');
            Route::post('/update/{id}', [UserController::class, 'update'])->name('users.update');
            Route::get('/profile', [UserController::class, 'profileView'])->name('profile');
            Route::get('/profile-view', [UserController::class, 'profile'])->name('profile.view');
        });

        Route::prefix('roles')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('roles.index');
            Route::get('/list', [RoleController::class, 'list'])->name('roles.list');
            Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
            Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
            Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
            Route::post('/update/{id}', [RoleController::class, 'update'])->name('roles.update');
            Route::delete('/delete/{id}', [RoleController::class, 'delete'])->name('roles.delete');
        });

        Route::prefix('permissions')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
            Route::get('/list', [PermissionController::class, 'list'])->name('permissions.list');
            Route::get('/create', [PermissionController::class, 'create'])->name('permissions.create');
            Route::post('/store', [PermissionController::class, 'store'])->name('permissions.store');
            Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
            Route::post('/update/{id}', [PermissionController::class, 'update'])->name('permissions.update');
            Route::delete('/delete/{id}', [PermissionController::class, 'delete'])->name('permissions.delete');
        });

        //AUTH
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});
