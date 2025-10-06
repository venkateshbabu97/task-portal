<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Role-based Gates
        Gate::define('isAdmin', function (User $user) {
            return $user->role->name === 'Admin';
        });

        Gate::define('isRequester', function (User $user) {
            return $user->role->name === 'Requester';
        });

        Gate::define('isContributor', function (User $user) {
            return $user->role->name === 'Contributor';
        });
    }
}
