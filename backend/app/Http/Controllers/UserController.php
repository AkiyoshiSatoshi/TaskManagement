<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\UseCases\User\DestroyAction;
use App\UseCases\User\IndexAction;
use App\UseCases\User\ShowAction;
use App\UseCases\User\StoreAction;
use App\UseCases\User\UpdateAction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request, IndexAction $action): ResourceCollection
    {
        Log::debug('IndexAction Controller');
        $user = $request->user();

        return UserResource::collection($action($user));
    }

    public function store(StoreRequest $request, StoreAction $action): UserResource
    {
        $user = $request->makeUser();

        Gate::authorize('store', $user);

        return new UserResource($action($user));
    }

    public function show(User $user, ShowAction $action): UserResource
    {
        return new UserResource($action($user));
    }

    public function update(UpdateRequest $request, User $user, UpdateAction $action): UserResource
    {
        $user = $request->makeUser($user);

        Gate::authorize('update', $user);

        return new UserResource($action($user));
    }

    public function destroy(User $user, DestroyAction $action): void
    {
        Gate::authorize('destroy', $user);

        $action($user);
    }
}
