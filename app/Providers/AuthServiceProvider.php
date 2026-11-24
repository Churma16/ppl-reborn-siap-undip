<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\IRS::class => \App\Policies\AcademicRecordPolicy::class,
        \App\Models\KHS::class => \App\Policies\AcademicRecordPolicy::class,
        \App\Models\PKL::class => \App\Policies\AcademicRecordPolicy::class,
        \App\Models\Skripsi::class => \App\Policies\AcademicRecordPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
