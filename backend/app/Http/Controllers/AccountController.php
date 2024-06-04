<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Account\UpdateRequest;
use App\Http\Resources\AccountResource;
use App\UseCases\Account\FetchMyAccountAction;
use App\UseCases\Account\UpdateMyAccountAction;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function fetchMyAccount(Request $request, FetchMyAccountAction $action): AccountResource
    {
        $user = $request->user();

        return new AccountResource($action($user));
    }

    public function updateMyAccount(UpdateRequest $request, UpdateMyAccountAction $action): AccountResource
    {
        $user = $request->makeAccount();

        return new AccountResource($action($user));
    }
}
