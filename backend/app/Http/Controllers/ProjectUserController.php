<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ProjectUser\StoreRequest;
use App\Http\Resources\ProjectUserResource;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use App\UseCases\ProjectUser\DestroyAction;
use App\UseCases\ProjectUser\IndexAction;
use App\UseCases\ProjectUser\StoreAction;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Gate;

class ProjectUserController extends Controller
{
    public function index(Project $project, IndexAction $action): ResourceCollection
    {
        return ProjectUserResource::collection($action($project));
    }

    public function store(StoreRequest $request, Project $project, StoreAction $action): ResourceCollection
    {
        $user = $request->user();
        $validated = $request->validated();

        Gate::authorize('store', [ProjectUser::class, $user]);

        return ProjectUserResource::collection($action($project, $validated));
    }

    public function destroy(Project $project, User $user, DestroyAction $action): void
    {
        Gate::authorize('destroy', [ProjectUser::class, $user]);

        $action($project, $user);
    }
}