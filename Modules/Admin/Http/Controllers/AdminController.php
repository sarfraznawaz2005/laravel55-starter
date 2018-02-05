<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\CoreController;
use Sarfraznawaz2005\VisitLog\Facades\VisitLog;

class AdminController extends CoreController
{
    use AuthenticatesUsers;

    protected $redirectTo = 'admin/panel';

    public function __invoke()
    {
        if (auth()->check() && user()->isSuperAdmin()) {
            return redirect(route('admin_panel'));
        }

        return view('admin::pages.login.index');
    }

    public function index()
    {
        title('Dashboard');

        return view('admin::pages.panel.index');
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

        // also check for "admin" status
        $credentials['admin'] = 1;

        // also check if user is active
        $credentials['active'] = 1;

        // also check if user is confirmed
        if (config('user.account_email_verification')) {
            $credentials['confirmed'] = 1;
        }

        if ($this->guard()->attempt($credentials, $request->has('remember'))) {

            // success
            alert(user()->full_name . '!', 'Welcome!')->autoclose(3000);

            VisitLog::save();

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Log the user out of admin.
     *
     * @param Request $request
     * @return Redirect
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        $request->session()->invalidate();

        flash('You are logged out.', 'success');

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : 'admin');
    }
}
