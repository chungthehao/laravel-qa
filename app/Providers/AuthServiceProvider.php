<?php

namespace App\Providers;

use App\Policies\QuestionPolicy;
use App\Question;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',

        // Cách 1: phải import namespace của 2 lớp
        Question::class => QuestionPolicy::class,
        // Cách 2: Khỏi import namespace
        'App\Answer' => 'App\Policies\AnswerPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Register some routes that necessary to issue access tokens. Revoke (thu hồi) access token clients and personal access token
        Passport::routes(); // Rồi chạy php artisan route:list --name=passport coi thử đi.
    }
}
