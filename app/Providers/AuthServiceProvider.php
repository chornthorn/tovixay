<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Role' => 'App\Policies\RolePolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\Computer' => 'App\Policies\ComputerPolicy',
        'App\Brand' => 'App\Policies\BrandPolicy',
        'App\Category' => 'App\Policies\CategoryPolicy',
        'App\CostCenter' => 'App\Policies\CostCenterPolicy',
        'App\Location' => 'App\Policies\LocationPolicy',
        'App\AssetModel' => 'App\Policies\AssetModelPolicy',
        'App\Report' => 'App\Policies\ReportPolicy',
        'App\Status' => 'App\Policies\StatusPolicy',
        'App\Asset' => 'App\Policies\AssetPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::resource('role', 'App\Policies\RolePolicy');
        Gate::resource('user', 'App\Policies\UserPolicy');
        Gate::resource('category', 'App\Policies\CategoryPolicy');
        Gate::resource('brand', 'App\Policies\BrandPolicy');
        Gate::resource('model', 'App\Policies\AssetModelPolicy');
        Gate::resource('location', 'App\Policies\LocationPolicy');
        Gate::resource('status', 'App\Policies\StatusPolicy');
        Gate::resource('costcenter', 'App\Policies\CostCenterPolicy');
        Gate::resource('asset', 'App\Policies\AssetPolicy');
        Gate::resource('computer', 'App\Policies\ComputerPolicy');
    }
}
