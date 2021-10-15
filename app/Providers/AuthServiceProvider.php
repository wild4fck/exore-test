<?php

namespace App\Providers;

use App\Models\Record;
use App\Models\User;
use App\Policies\EmployeePolicy;
use App\Policies\RecordPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider {
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
        Record::class => RecordPolicy::class,
        User::class => EmployeePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();

        Gate::define('view-by-author', [RecordPolicy::class, 'viewByAuthor']);
    }
}
