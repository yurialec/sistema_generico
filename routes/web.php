<?php

use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UsuarioController;
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

        Route::prefix('usuarios')->group(function () {
            Route::get('/', [UsuarioController::class, 'index'])->name('usuarios.index');
            Route::get('/list', [UsuarioController::class, 'list'])->name('usuarios.list');
            Route::get('/cadastrar', [UsuarioController::class, 'create'])->name('usuarios.cadastrar');
            Route::post('/cadastrar', [UsuarioController::class, 'store'])->name('usuarios.store');
        });

        Route::prefix('perfis')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        });

        //AUTH
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});
