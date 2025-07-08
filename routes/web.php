<?php

use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\LogoController;
use App\Http\Controllers\Site\MainTextController;
use App\Http\Controllers\Site\SiteAboutController;
use App\Http\Controllers\Site\SiteCarouselController;
use App\Http\Controllers\Site\SocialMediaController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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

Route::get('/', [SiteController::class, 'index'])->name('site.home');
Route::get('/sobre', [SiteController::class, 'about'])->name('site.about');
Route::get('/contato', [SiteController::class, 'contact'])->name('site.contact');
Route::get('/enviar-link', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

Route::middleware(['auth'])->group(function () {

    Route::prefix('admin/')->group(function () {
        //dont need acl
        Route::get('home', [HomeController::class, 'index'])->name('home');
        Route::get('sidebar', [MenuController::class, 'sidebar'])->name('sidebar');
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/profile-view', [UserController::class, 'profileView'])->name('profile.view');
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');

        Route::middleware('acl:keep-users')->group(function () {
            Route::prefix('users')->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('users.index');
                Route::get('/list', [UserController::class, 'list'])->name('users.list');
                Route::get('/create', [UserController::class, 'create'])->name('users.create');
                Route::post('/store', [UserController::class, 'store'])->name('users.store');
                Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
                Route::get('/find/{id}', [UserController::class, 'find'])->name('users.find');
                Route::post('/update/{id}', [UserController::class, 'update'])->name('users.update');
                Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
            });
        });

        Route::middleware('acl:keep-roles')->group(function () {
            Route::prefix('roles')->group(function () {
                Route::get('/', [RoleController::class, 'index'])->name('roles.index');
                Route::get('/list', [RoleController::class, 'list'])->name('roles.list');
                Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
                Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
                Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
                Route::post('/update/{id}', [RoleController::class, 'update'])->name('roles.update');
                Route::get('/find/{id}', [RoleController::class, 'find'])->name('roles.find');
                Route::delete('/delete/{id}', [RoleController::class, 'delete'])->name('roles.delete');
                Route::get('/list-permissions', action: [RoleController::class, 'listPermissions'])->name('roles.list.permissions');
            });
        });

        Route::middleware('acl:keep-permissions')->group(function () {
            Route::prefix('permissions')->group(function () {
                Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
                Route::get('/list', [PermissionController::class, 'list'])->name('permissions.list');
                Route::get('/create', [PermissionController::class, 'create'])->name('permissions.create');
                Route::post('/store', [PermissionController::class, 'store'])->name('permissions.store');
                Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
                Route::get('/find/{id}', [PermissionController::class, 'find'])->name('permissions.find');
                Route::post('/update/{id}', [PermissionController::class, 'update'])->name('permissions.update');
                Route::delete('/delete/{id}', [PermissionController::class, 'delete'])->name('permissions.delete');
            });
        });

        Route::middleware('acl:keep-menu')->group(function () {
            Route::prefix('menu')->group(function () {
                Route::get('/', [MenuController::class, 'index'])->name('menu.index');
                Route::get('/list', [MenuController::class, 'list'])->name('menu.list');
                Route::get('/create', [MenuController::class, 'create'])->name('menu.create');
                Route::post('/store', [MenuController::class, 'store'])->name('menu.store');
                Route::get('/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
                Route::post('/update/{id}', [MenuController::class, 'update'])->name('menu.update');
                Route::get('/find/{id}', [MenuController::class, 'find'])->name('menu.find');
                Route::delete('/delete/{id}', [MenuController::class, 'delete'])->name('menu.delete');
                Route::post('/change-order-menu/{id}', [MenuController::class, 'changeOrderMenu'])->name('menu.changeOrderMenu');
            });
        });

        Route::prefix('site/')->group(function () {
            Route::middleware('acl:keep-logo')->group(function () {
                Route::prefix('logo')->group(function () {
                    Route::get('/', [LogoController::class, 'index'])->name('site.logo.index');
                    Route::get('/get-logo', [LogoController::class, 'getLogo'])->name('site.logo.getLogo');
                    Route::get('/create', [LogoController::class, 'create'])->name('site.logo.create');
                    Route::post('/store', [LogoController::class, 'store'])->name('site.logo.store');
                    Route::get('/edit/{id}', [LogoController::class, 'edit'])->name('site.logo.edit');
                    Route::get('/find/{id}', [LogoController::class, 'find'])->name('site.logo.find');
                    Route::post('/update/{id}', [LogoController::class, 'update'])->name('site.logo.update');
                    Route::delete('/delete/{id}', [LogoController::class, 'delete'])->name('site.logo.delete');
                });
            });

            Route::middleware('acl:keep-main-text')->group(function () {
                Route::prefix('main-text')->group(function () {
                    Route::get('/', [MainTextController::class, 'index'])->name('site.maintext.index');
                    Route::get('/get-main-text', [MainTextController::class, 'getMainText'])->name('site.maintext.getMainText');
                    Route::get('/create', [MainTextController::class, 'create'])->name('site.maintext.create');
                    Route::post('/store', [MainTextController::class, 'store'])->name('site.maintext.store');
                    Route::get('/edit/{id}', [MainTextController::class, 'edit'])->name('site.maintext.edit');
                    Route::get('/find/{id}', [MainTextController::class, 'find'])->name('site.maintext.find');
                    Route::post('/update/{id}', [MainTextController::class, 'update'])->name('site.maintext.update');
                    Route::delete('/delete/{id}', [MainTextController::class, 'delete'])->name('site.maintext.delete');
                });
            });

            Route::middleware('acl:keep-carousel')->group(function () {
                Route::prefix('carousel')->group(function () {
                    Route::get('/', [SiteCarouselController::class, 'index'])->name('site.carousel.index');
                    Route::get('/list', [SiteCarouselController::class, 'list'])->name('site.carousel.list');
                    Route::get('/create', [SiteCarouselController::class, 'create'])->name('site.carousel.create');
                    Route::post('/store', [SiteCarouselController::class, 'store'])->name('site.carousel.store');
                    Route::get('/edit/{id}', [SiteCarouselController::class, 'edit'])->name('site.carousel.edit');
                    Route::post('/update/{id}', [SiteCarouselController::class, 'update'])->name('site.carousel.update');
                    Route::delete('/delete/{id}', [SiteCarouselController::class, 'delete'])->name('site.carousel.delete');
                });
            });

            Route::middleware('acl:keep-site-about')->group(function () {
                Route::prefix('site-about')->group(function () {
                    Route::get('/', [SiteAboutController::class, 'index'])->name('site.about.index');
                    Route::get('/list', [SiteAboutController::class, 'list'])->name('site.about.list');
                    Route::get('/create', [SiteAboutController::class, 'create'])->name('site.about.create');
                    Route::post('/store', [SiteAboutController::class, 'store'])->name('site.about.store');
                    Route::get('/edit/{id}', [SiteAboutController::class, 'edit'])->name('site.about.edit');
                    Route::post('/update/{id}', [SiteAboutController::class, 'update'])->name('site.about.update');
                    Route::delete('/delete/{id}', [SiteAboutController::class, 'delete'])->name('site.about.delete');
                });
            });

            Route::middleware('acl:keep-contact')->group(function () {
                Route::prefix('contact')->group(function () {
                    Route::get('/', [ContactController::class, 'index'])->name('site.contact.index');
                    Route::get('/list', [ContactController::class, 'list'])->name('site.contact.list');
                    Route::get('/create', [ContactController::class, 'create'])->name('site.contact.create');
                    Route::post('/store', [ContactController::class, 'store'])->name('site.contact.store');
                    Route::get('/edit/{id}', [ContactController::class, 'edit'])->name('site.contact.edit');
                    Route::post('/update/{id}', [ContactController::class, 'update'])->name('site.contact.update');
                    Route::delete('/delete/{id}', [ContactController::class, 'delete'])->name('site.contact.delete');
                });
            });

            Route::middleware('acl:keep-social-media')->group(function () {
                Route::prefix('social-media')->group(function () {
                    Route::get('/', [SocialMediaController::class, 'index'])->name('site.socialmedia.index');
                    Route::get('/list', [SocialMediaController::class, 'list'])->name('site.socialmedia.list');
                    Route::get('/create', [SocialMediaController::class, 'create'])->name('site.socialmedia.create');
                    Route::post('/store', [SocialMediaController::class, 'store'])->name('site.socialmedia.store');
                    Route::get('/edit/{id}', [SocialMediaController::class, 'edit'])->name('site.socialmedia.edit');
                    Route::post('/update/{id}', [SocialMediaController::class, 'update'])->name('site.socialmedia.update');
                    Route::delete('/delete/{id}', [SocialMediaController::class, 'delete'])->name('site.socialmedia.delete');
                });
            });
        });
    });

    Route::get('/cep/{cep}', function ($cep) {
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");
        return $response->json();
    });
});