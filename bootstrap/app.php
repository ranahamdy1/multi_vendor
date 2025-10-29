<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //  هذا الميدل وير سيشتغل في كل الطلبات في التطبيق
        $middleware->append([
            \App\Http\Middleware\MarkNotificationAsRead::class,
        ]);

        //  تعريف أسماء مختصرة للميدل ويرات الأخرى
        $middleware->alias([
            'auth.type' => \App\Http\Middleware\CheckUserType::class,
            'lastActive' => \App\Http\Middleware\UpdateUserLastActiveAt::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
