<?php

use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ValidRoutesController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Site\LogoController;
use App\Http\Controllers\Site\MainTextController;
use App\Http\Controllers\SiteController;
use App\Models\Site\SiteCarrousel;
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

Auth::routes();

Route::get('/', [SiteController::class, 'index']);
Route::post('/password-reset', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::middleware('auth')->group(function () {

    Route::prefix('admin/')->group(function () {

        //dont need acl
        Route::get('home', [HomeController::class, 'index'])->name('home');
        Route::get('menus', [MenuController::class, 'menus'])->name('menus');
        Route::get('modules/list', [ModuleController::class, 'list'])->name('modules.list');


        Route::middleware('acl')->group(function () {

            Route::prefix('users')->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('users.index');
                Route::get('/list', [UserController::class, 'list'])->name('users.list');
                Route::get('/create', [UserController::class, 'create'])->name('users.create');
                Route::post('/store', [UserController::class, 'store'])->name('users.store');
                Route::get('/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
                Route::post('/update/{id}', [UserController::class, 'update'])->name('users.update');
                Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('users.delete');

                //dont need acl
                Route::get('/profile-view', [UserController::class, 'profileView'])->name('profile.view');
                Route::get('/profile', [UserController::class, 'profile'])->name('profile');
            });

            Route::prefix('roles')->group(function () {
                Route::get('/', [RoleController::class, 'index'])->name('roles.index');
                Route::get('/list', [RoleController::class, 'list'])->name('roles.list');
                Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
                Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
                Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
                Route::post('/update/{id}', [RoleController::class, 'update'])->name('roles.update');
                Route::delete('/delete/{id}', [RoleController::class, 'delete'])->name('roles.delete');

                //dont need acl
                Route::get('/list-permissions', [RoleController::class, 'listPermissions'])->name('roles.list.permissions');
            });

            Route::prefix('permissions')->group(function () {
                Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
                Route::get('/list', [PermissionController::class, 'list'])->name('permissions.list');
                Route::get('/create', [PermissionController::class, 'create'])->name('permissions.create');
                Route::post('/store', [PermissionController::class, 'store'])->name('permissions.store');
                Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
                Route::post('/update/{id}', [PermissionController::class, 'update'])->name('permissions.update');
                Route::delete('/delete/{id}', [PermissionController::class, 'delete'])->name('permissions.delete');
                Route::get('/valid-routes', [ValidRoutesController::class, 'index'])->name('valid.routes.index');
            });

            Route::prefix('menu')->group(function () {
                Route::get('/', [MenuController::class, 'index'])->name('menu.index');
                Route::get('/list', [MenuController::class, 'list'])->name('menu.list');
                Route::get('/create', [MenuController::class, 'create'])->name('menu.create');
                Route::post('/store', [MenuController::class, 'store'])->name('menu.store');
                Route::get('/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
                Route::post('/update/{id}', [MenuController::class, 'update'])->name('menu.update');
                Route::delete('/delete/{id}', [MenuController::class, 'delete'])->name('menu.delete');
            });

            Route::prefix('site/')->group(function () {
                Route::prefix('logo')->group(function () {
                    Route::get('/', [LogoController::class, 'index'])->name('site.logo.index');
                    Route::get('/list', [LogoController::class, 'list'])->name('site.logo.list');
                    Route::get('/create', [LogoController::class, 'create'])->name('site.logo.create');
                    Route::post('/store', [LogoController::class, 'store'])->name('site.logo.store');
                    Route::get('/edit/{id}', [LogoController::class, 'edit'])->name('site.logo.edit');
                    Route::post('/update/{id}', [LogoController::class, 'update'])->name('site.logo.update');
                    Route::delete('/delete/{id}', [LogoController::class, 'delete'])->name('site.logo.delete');
                });

                Route::prefix('main-text')->group(function () {
                    Route::get('/', [MainTextController::class, 'index'])->name('site.maintext.index');
                    Route::get('/list', [MainTextController::class, 'list'])->name('site.maintext.list');
                    Route::get('/create', [MainTextController::class, 'create'])->name('site.maintext.create');
                    Route::post('/store', [MainTextController::class, 'store'])->name('site.maintext.store');
                    Route::get('/edit/{id}', [MainTextController::class, 'edit'])->name('site.maintext.edit');
                    Route::post('/update/{id}', [MainTextController::class, 'update'])->name('site.maintext.update');
                    Route::delete('/delete/{id}', [MainTextController::class, 'delete'])->name('site.maintext.delete');
                });

                Route::prefix('carousel')->group(function () {
                    Route::get('/', [SiteCarrousel::class, 'index'])->name('site.carrousel.index');
                    Route::get('/list', [SiteCarrousel::class, 'list'])->name('site.carrousel.list');
                    Route::get('/create', [SiteCarrousel::class, 'create'])->name('site.carrousel.create');
                    Route::post('/store', [SiteCarrousel::class, 'store'])->name('site.carrousel.store');
                    Route::get('/edit/{id}', [SiteCarrousel::class, 'edit'])->name('site.carrousel.edit');
                    Route::post('/update/{id}', [SiteCarrousel::class, 'update'])->name('site.carrousel.update');
                    Route::delete('/delete/{id}', [SiteCarrousel::class, 'delete'])->name('site.carrousel.delete');
                });
            });
        });

        //AUTH
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});
