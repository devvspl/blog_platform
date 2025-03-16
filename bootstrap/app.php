<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Sanctum Middleware to Handle API Token
        $middleware->group('api', [
            EnsureFrontendRequestsAreStateful::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle 403 Unauthorized Error with JSON Response
        $exceptions->renderable(function (\Illuminate\Auth\Access\AuthorizationException $e, $request) {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized to access this route',
                'data' => null,
            ], 403);
        });

        // Handle Authentication Error
        $exceptions->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or missing API token',
                'data' => null,
            ], 401);
        });

        // Handle Validation Errors
        $exceptions->renderable(function (\Illuminate\Validation\ValidationException $e, $request) {
            return response()->json([
                'status' => false,
                'message' => $e->errors(),
                'data' => null,
            ], 422);
        });

        // Handle Other Server Errors
        $exceptions->renderable(function (\Exception $e, $request) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong on the server',
                'data' => null,
            ], 500);
        });
    })->create();
