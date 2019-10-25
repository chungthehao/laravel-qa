<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Question;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        # Define custom route model bindings
        //Route::bind('slug', function($slug) {
            /* Cách 1: cách cơ bản */
            // $question = Question::where('slug', $slug)->first();
            // return $question ? $question : abort(404);

            /* Cách 2 (để giải quyết vấn đề N+1 query) */
            //return Question::with('answers.user')->where('slug', $slug)->first() ?? abort(404);

            # Cách 1 để sắp xếp answer nhiều vote xếp trước
//            return Question::with(['answers.user', 'answers' => function ($query) {
//                    $query->orderBy('votes_count', 'desc');
//                }])->where('slug', $slug)->first() ?? abort(404);

            # Cách 2 để sắp xếp answer nhiều vote xếp trước, để như dưới, rồi thêm thắt trong Question model
            //return Question::with(['answers.user', 'user'])->where('slug', $slug)->first() ?? abort(404);
            //--------------user của các answers | user của question

            // Tách việc query question và các answers liên quan đến nó ra, để việc 'Load more answers' dễ thực hiện
            //return Question::with(['user'])->where('slug', $slug)->first() ?? abort(404);

            # Eager loading (solve N+1 query problem)
            // with('answers.user') có ý nghĩa là
            // answers : relation trong Question model
            // user : relation trong Answer model
        //});

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
