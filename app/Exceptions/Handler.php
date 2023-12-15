<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
     * @param \Throwable $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        if (env('APP_ENV') != "local") {
            if (app()->bound('sentry') && $this->shouldReport($exception)) {
                app('sentry')->captureException($exception);
            }
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $message = $exception->getMessage();
        if ($exception instanceof \Yajra\DataTables\Exception) {
            if (app()->bound('sentry')) {
                app('sentry')->captureException($exception);
            }
            return response([
                'draw' => 0,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => true,
                'error_message' => $message,
            ]);
        }

        return parent::render($request, $exception);
    }
}
