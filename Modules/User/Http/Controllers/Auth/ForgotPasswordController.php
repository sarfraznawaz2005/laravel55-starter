<?php

namespace Modules\User\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Modules\Core\Http\Controllers\CoreController;

class ForgotPasswordController extends CoreController
{
    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        title('Reset Your Password');

        return view('user::auth.passwords.email');
    }

    public function __construct()
    {
        $this->middleware('guest');
    }
}
