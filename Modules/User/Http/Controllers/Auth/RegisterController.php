<?php

namespace Modules\User\Http\Controllers\Auth;

use function abort;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Core\Http\Controllers\CoreController;
use Modules\User\Models\User;
use Modules\User\Notifications\UserWasRegistered;
use Modules\User\Notifications\VerifyRegister;

class RegisterController extends CoreController
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');

        $this->redirectTo = config('user.redirect_route_after_register', '/');
        
        parent::__construct();
    }

    public function showRegistrationForm()
    {
        if (!config('user.allow_user_registration')) {
            abort(404);
        }

        title('Create Account');

        return view('user::auth.register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \Modules\User\Models\User
     */
    protected function create(array $data)
    {
        if (!config('user.allow_user_registration')) {
            abort(404);
        }

        $user = new User();

        $confirmationCode = str_random(30);

        $instance = $user->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'confirmation_code' => $confirmationCode,
            'active' => config('user.activate_user_on_registration') ? 1 : 0,
            'confirmed' => config('user.account_email_verification') ? 0 : 1,
        ]);

        if (config('user.account_email_verification')) {
            sendNotification($instance->email, new VerifyRegister($instance));

            flash('Thanks for signing up! Please check your email to verify your account.', 'success');
        } else {
            // direct registration without verification process
            if (!count($instance->errors())) {
                sendNotification($instance->email, new UserWasRegistered($instance));

                flash('Your account has been created successfully!', 'success');
            }
        }

        return $instance;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        if (!config('user.allow_user_registration')) {
            abort(404);
        }

        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        if (!config('user.account_email_verification')) {
            $this->guard()->login($user);
        }

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    public function confirm($confirmationCode)
    {
        if (!$confirmationCode) {
            flash('Invalid Token Code', 'error');

            return redirect()->back();
        }

        $user = User::whereConfirmationCode($confirmationCode)->first();

        if (!$user) {
            flash('Invalid token or you are already verified user.', 'warning');
            return redirect()->to('/');
        }

        if (config('user.activate_user_on_registration')) {
            $user->active = 1;
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        // send email
        sendNotification($user->email, new UserWasRegistered($user));

        flash('You have successfully verified your account.', 'success');

        return redirect()->route('login');
    }
}
