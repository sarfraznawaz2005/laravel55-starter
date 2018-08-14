<?php

namespace Modules\User\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Modules\Core\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use Modules\User\Models\User;
use Modules\User\Notifications\VerifyRegister;
use Sarfraznawaz2005\VisitLog\Facades\VisitLog;

class LoginController extends CoreController
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        $this->redirectTo = config('user.redirect_route_after_login', '/');

        parent::__construct();
    }

    public function showLoginForm()
    {
        title('Signin To Your Account');

        return view('user::auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->credentials($request);

        // check if user is registered but not verified, in this case re-send
        // them verification email
        if (config('user.account_email_verification')) {
            $user = User::where('email', $credentials['email'])->where('confirmed', 0)->first();

            if ($user) {
                // re-create confirmation code if it is empty currently
                if (!$user->confirmation_code) {
                    $user->confirmation_code = str_random(30);
                    $user->save();
                }

                // send verification email
                sendNotification($user->email, new VerifyRegister($user));

                flash('Please check your email to verify your account.', 'info');
                return redirect()->back();
            }
        }

        // also check if user is active
        $credentials['active'] = 1;

        // also check if user is confirmed
        if (config('user.account_email_verification')) {
            $credentials['confirmed'] = 1;
        }

        if ($this->guard()->attempt($credentials, $request->has('remember'))) {
            // logged in successfully

            noty('Welcome ' . user()->name);

            VisitLog::save();

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string|email',
            'password' => 'required|string',
        ]);
    }

    public function username()
    {
        return 'email';
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();
        $request->session()->regenerate();
        $request->session()->invalidate();

        noty('You are logged out.', 'warning');

        return redirect(config('user.redirect_route_after_logout', '/'));
    }
}
