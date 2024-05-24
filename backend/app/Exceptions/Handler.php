<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->renderable(function (Throwable $e) {
            $title = '';
            $detail = '';
            $status = '';

            if ($e instanceof AuthenticationException) {
                $title = '認証に失敗しました';
                $detail = $e->getMessage() ?: $title;
                $status = 401;
            } elseif ($e instanceof AuthorizationException) {
                $title = '認可に失敗しました';
                $detail = $e->getMessage() ?: $title;
                $status = 403;
            } elseif ($e instanceof NotFoundHttpException | $e instanceof ModelNotFoundException) {
                $title = 'リソースが見つかりません';
                $detail = $e->getMessage() ?: $title;
                $status = 404;
            } elseif ($e instanceof MethodNotAllowedException) {
                $title = 'メソッドが許可されていません';
                $detail = $e->getMessage() ?: $title;
                $status = 405;
            } elseif ($e instanceof ValidationException) {
                $title = '入力値が不正です';
                $detail = $e->errors() ?: $title;
                $status = 422;
                logs()->warning($e->getMessage());
            } elseif ($e instanceof ThrottleRequestsException) {
                $title = 'リクエストが多すぎます';
                $detail = $e->getMessage() ?: $title;
                $status = 429;
            } elseif ($e instanceof HttpException) {
                $title = 'HTTPエラー';
                $detail = $e->getMessage() ?: $title;
                $status = $e->getStatusCode();
                logs()->error($e->getMessage());
            } elseif ($e instanceof CustomException) {
                $title = 'カスタムエラー';
                $detail = $e->getMessage();
                $status = $e->getStatusCode();
            } else {
                $title = 'システムエラー';
                $detail = $e->getMessage() ?: $title;
                $status = 500;
                logs()->error($e->getMessage());
            }

            return response()->json(
                [
                    'title' => $title,
                    'detail' => $detail,
                ],
                $status,
                [],
                JSON_UNESCAPED_UNICODE,
            );
        });
    }
}
