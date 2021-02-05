<?php

namespace App\Exceptions;

use App\Traits\ResponseTraits;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Handler extends ExceptionHandler
{

    use ResponseTraits;
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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return response()->json([
                'errors' => Arr::collapse($exception->errors())
            ], 422);
            // return $this->errorResponse($exception->errors());
        }

        if ($exception instanceof UnauthorizedException) {
            return $this->errorResponse("Unauthorized", 401);
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->errorResponse('Entity Not found', 400);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('Not found', 400);
        }

        if ($exception instanceof RouteNotFoundException) {
            return $this->errorResponse('Not found', 400);
        }

        return parent::render($request, $exception);
    }
}
