<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Models\HistorialSession;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen(Login::class, function ($event) {
            HistorialSession::create([
                'user_id' => $event->user->id,
                'fecha_inicio' => now(),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });

        Event::listen(Logout::class, function ($event) {
            HistorialSession::where('user_id', $event->user->id)
                ->whereNull('fecha_fin')
                ->latest()
                ->first()
                ?->update([
                    'fecha_fin' => now(),
                ]);
        });
    }
}
