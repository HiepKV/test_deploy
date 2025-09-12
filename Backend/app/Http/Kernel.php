<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Global middleware (chạy cho mọi request)
     */
    protected $middleware = [
        \Illuminate\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class, // Laravel CORS built-in
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    ];

    /**
     * Middleware groups
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        ],

        'api' => [
            // Sanctum xử lý cookie/token cho SPA
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,

            // CORS xử lý cho API (cái này Laravel tự nhận, không cần custom middleware)
            \Illuminate\Http\Middleware\HandleCors::class,

            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];
}
