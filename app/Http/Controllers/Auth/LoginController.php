<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getToken(Request $request)
    {
        // Tại sao request token trên server (here) mà ko ở phía browser?
        // -> Lưu client_id, client_secret ở phía browser nguy cơ lộ thông tin cao
        /**
         * # To hit the oauth/token endpoint & get the token back -> need to pass at least 5 things:
         * -> grant_type, client_id, client_secret, username, password
         */
        $request->request->add([ // Đưa 5 thông tin đó vô $request object
            'grant_type' => 'password',
            'client_id' => 3,
            'client_secret' => 'E5BogcxI4pls6wHeJwkvJidAnKLUE3flqDmPE3U8',
            'username' => $request->post('username'),
            'password' => $request->post('password'),
        ]);

        # Bắt đầu request tới /oauth/token
        // Chuẩn bị $requestToken object
        $requestToken = Request::create(env('APP_URL') . '/oauth/token', 'POST');
        // Actually hit the end point
        $response = Route::dispatch($requestToken);

        return $response;
    }
}
