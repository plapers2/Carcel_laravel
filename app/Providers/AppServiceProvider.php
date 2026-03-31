<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Illuminate\Support\HtmlString;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Filament::registerRenderHook(
            'panels::auth.login.form.after',
            fn() => new HtmlString('
            <div style="margin-top: 10px; text-align: center;">
                <a href="' . route('visitor.create') . '" style="color: orange;" class="text-sm hover:underline">
                    Register a visitor
                </a>
            </div>
        ')
        );
    }
}
