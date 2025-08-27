<?php

namespace App\Providers;

use App\Http\ViewComposers\FooterComposer;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Interfaces\Admin\RoleRepositoryInterface::class,
            \App\Repositories\Admin\RoleRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('site.layouts.footer', FooterComposer::class);
    }
}
