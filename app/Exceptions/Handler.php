<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];


    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response|string|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        $referrer = $request->server->get('referer');

        // redirect to home in case of 404
        if ($this->isHttpException($exception)) {
            switch ($exception->getStatusCode()) {
                case 404:
                    return redirect('/');
                    break;
            }

            return $this->renderHttpException($exception);
        }

        // show 404 page in case of ModelNotFoundException error
        if ($exception instanceof ModelNotFoundException) {
            if ($referrer) {
                return redirect()->back()->withErrors([
                    'error' => 'Invaid Resource!'
                ]);
            }

            return \Response::view('errors.404', array(), 404);
        }

        // redirect user back in case of token mismatch error
        if ($exception instanceof TokenMismatchException) {

            if ($request->ajax()) {
                return 'Sorry, your session seems to have expired. Please try again.';
            }

            return redirect()
                ->back()
                ->withErrors(['error' => 'Sorry, your session seems to have expired. Please try again.'])
                ->withInput($request->except('password', 'password_confirmation', '_token'));
        }

        return parent::render($request, $exception);
    }
}
