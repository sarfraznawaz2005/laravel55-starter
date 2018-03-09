<?php

namespace Modules\User\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Modules\Core\Http\Controllers\CoreController;
use Illuminate\Http\Request;

class ResetPasswordController extends CoreController
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
        
        parent::__construct();
    }

    public function showResetForm(Request $request, $token = null)
    {
        title('Reset Your Password');

        return view('user::auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
