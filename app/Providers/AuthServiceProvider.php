<?php

namespace App\Providers;

use App\Filament\Pages\Reportes;
use App\Models\User;
use App\Models\visits;
use App\Policies\PermissionPolicy;
use App\Policies\ReportPolicy;
use Spatie\Permission\Models\Role;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Policies\VisitaPolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     */
    protected $policies = [
        // Aquí registras tus policies
        // Ejemplo:
        visits::class => VisitaPolicy::class,
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        Reportes::class => ReportPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
