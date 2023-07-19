<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Laravel\Sanctum\Exceptions\MissingAbilityException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception)
    {
        if ( $exception instanceof MissingAbilityException) {
            return response()->json(['error' => 'Forbidden', 'status' => 403], 403);
        }

        if ($exception instanceof NotFoundHttpException) {
            
            return response()->json(['error' => 'Not found', 'status' => 404], 404);
        }

        if ($exception instanceof AuthenticationException ) {
            return response()->json(['error' => 'Unauthorized', 'status' => 401], 401);
        }
        return response()->json(['error' => 'internal server error.'.get_class($exception).' - '.$exception->getmessage()], 501);

      
    }
}
