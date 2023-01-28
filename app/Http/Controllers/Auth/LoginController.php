<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('pages.auth.login', compact('pageConfigs'));
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        $username = request()->input('username');
        $field = filter_var($username, FILTER_VALIDATE_EMAIL)
            ? 'email' : 'username';

        request()->merge([$field => $username]);

        return $field;
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $user = User::where($attribute, $value)->firstOrFail();
                    if ($user->status === "suspend") {
                        $fail('Akun anda di non-aktifkan. Silahkan hubungi admin.');
                    }
                }
            ],
            'password' => 'required|string',
        ]);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $user = User::where($this->username(), request()->input('username'))->firstOrFail();
        $token = $user->createToken('key')->plainTextToken;
        return [
            "success" => true,
            "redirectTo" => url($this->redirectPath()),
            "token" => $token,
        ];
    }
}
