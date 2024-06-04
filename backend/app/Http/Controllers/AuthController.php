<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\EmailAuthenticationException;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(LoginRequest $request): UserResource
    {
        $credentials = $request->only(['email', 'password']);

        if (! Auth::guard()->attempt($credentials)) {
            throw new AuthenticationException('ログインに失敗しました');
        }

        $verify_check = Auth::guard()->user()->email_verified_at;
        if ($verify_check === null) {
            throw new EmailAuthenticationException('メール認証が完了していません');
        }

        $request->session()->regenerate();

        return new UserResource(Auth::guard()->user());
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return new JsonResponse(null);
    }
}
