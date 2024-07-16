<?php

use Carbon\Exceptions\InvalidTypeException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // return $this->sendError('Internal Server Error', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return response()->json([
                "status" => Response::HTTP_NOT_FOUND,
                'message' => $e->getMessage()

            ], Response::HTTP_NOT_FOUND);
        });
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return response()->json([
                "status" => Response::HTTP_UNAUTHORIZED,
                'message' => $e->getMessage()

            ], Response::HTTP_UNAUTHORIZED);
        });
        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            return response()->json([
                "status" => Response::HTTP_UNAUTHORIZED,
                'message' => $e->getMessage()

            ], Response::HTTP_UNAUTHORIZED);
        });

        $exceptions->render(function (Exception $e, Request $request) {
            return response()->json([
                "status" => Response::HTTP_INTERNAL_SERVER_ERROR,
                // 'message' => "Internal Server Error"
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    })->create();
