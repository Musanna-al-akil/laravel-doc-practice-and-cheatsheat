<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use PDOException;
use Psr\Log\LogLevel;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected function context(): array
{
    return array_merge(parent::context(), [
        'foo' => 'bar',
    ]);
}
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];
    protected $levels = [
        PDOException::class => LogLevel::CRITICAL,
        InvalidOrderException::class => LogLevel::CRITICAL,
    ];
    

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        //13.1 setup sentry
        $this->reportable(function (Throwable $e) {
            if (app()->bound('sentry')) {
              app('sentry')->captureException($e);
            }
        });
    }
}
