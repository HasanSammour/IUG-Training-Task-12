<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\EnsureEssentialData;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register middleware aliases
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'essential.data' => EnsureEssentialData::class,  // Now we will use This middleware in home route only
        ]);                                                  // So Essential & Roles seeders will checked in home page only    

        // Add middleware groups
        $middleware->group('admin', [
            'auth',
            'verified',
            'role:admin',
        ]);

        $middleware->group('instructor', [
            'auth',
            'verified',
            'role:instructor',
        ]);

        $middleware->group('student', [
            'auth',
            'verified',
            'role:student',
        ]);

        // This will make The seeder runs in each page
        // $middleware->web(append: [
            // EnsureEssentialData::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle 404 Not Found
        $exceptions->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Route not found',
                    'data' => null
                ], 404);
            }

            return response()->view('errors.404', [], 404);
        });

        // Handle 403 Forbidden
        $exceptions->renderable(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 403) {
                if ($request->is('api/*') || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You are not authorized to access this resource.',
                        'data' => null
                    ], 403);
                }

                return response()->view('errors.403', [], 403);
            }
        });

        // Handle 401 Unauthorized
        $exceptions->renderable(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated.',
                    'data' => null
                ], 401);
            }

            return redirect()->guest(route('login'));
        });

        // Handle 419 Session Expired
        $exceptions->renderable(function (TokenMismatchException $e, Request $request) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your session has expired. Please refresh the page.',
                    'data' => null
                ], 419);
            }

            return response()->view('errors.419', [], 419);
        });

        // Handle 429 Too Many Requests
        $exceptions->renderable(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 429) {
                if ($request->is('api/*') || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Too many requests. Please try again later.',
                        'data' => null
                    ], 429);
                }

                return response()->view('errors.429', [], 429);
            }
        });

        // when i use This it's effect Form Validation So i comment it
        // // Handle 500 Internal Server Error
        // $exceptions->renderable(function (Throwable $e, Request $request) {
        //     if ($request->is('api/*') || $request->wantsJson()) {
        //         return response()->json([
        //             'success' => false,
        //             'message' => 'An internal server error occurred.',
        //             'data' => null
        //         ], 500);
        //     }
    
        //     return response()->view('errors.500', [], 500);
        // });
    
        // Handle 503 Service Unavailable
        $exceptions->renderable(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 503) {
                if ($request->is('api/*') || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Service is temporarily unavailable.',
                        'data' => null
                    ], 503);
                }

                return response()->view('errors.503', [], 503);
            }
        });
    })
    ->withProviders([
        \Spatie\Permission\PermissionServiceProvider::class,
    ])
    ->create();