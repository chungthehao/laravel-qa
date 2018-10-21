<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        # Khi sử dụng Gate để xác thực trong các actions, chỉ cần cung cấp
        // đối tượng $question, không cần truyền đối tượng $user, laravel
        // tự làm việc đó cho mình (behind the scene).
        Gate::define('update-question', function($user, $question) {
            return $user->id === $question->user_id;
        });

        Gate::define('delete-question', function($user, $question) {
            return $user->id === $question->user_id;
        });
    }
}
