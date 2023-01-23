<?php

namespace App\Providers;
use App\Models\User;
use App\Policies\OwnerPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Access\Response;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];


    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-personal', function (User $user)
        {
            return $user->role_id == '1'
                        ? Response::allow()
                        : Response::deny('Acción no permitida');
        });

        Gate::define('manage-commerces', function (User $user)
        {
            return $user->role_id == '1';
        });        

        Gate::define('manage-products', function (User $user)
        {
            return $user->role_id == '2'
                        ? Response::allow()
                        : Response::deny('Acción no permitida');            
        });

        Gate::define('manage-orders', function (User $user)
        {
            return $user->role_id == '3';
        });
    }
}
