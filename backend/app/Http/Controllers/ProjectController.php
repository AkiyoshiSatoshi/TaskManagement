<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Project\IndexRequest;
use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\UseCases\Project\DestroyAction;
use App\UseCases\Project\IndexAction;
use App\UseCases\Project\ShowAction;
use App\UseCases\Project\StoreAction;
use App\UseCases\Project\UpdateAction;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    public function index(IndexRequest $request, IndexAction $action): ResourceCollection
    {
        $user = $request->user();

        return ProjectResource::collection($action($user));
    }

    public function store(StoreRequest $request, StoreAction $action): ProjectResource
    {
        $user = $request->user();
        $project = $request->makeProject();

        Gate::authorize('store', $project);

        return new ProjectResource($action($user, $project));
    }

    public function show(Project $project, ShowAction $action): ProjectResource
    {
        return new ProjectResource($action($project));
    }

    public function update(UpdateRequest $request, Project $project, UpdateAction $action): ProjectResource
    {
        $project = $request->makeProject($project);

        Gate::authorize('update', $project);

        return new ProjectResource($action($project));
    }

    public function destroy(Project $project, DestroyAction $action): void
    {
        Gate::authorize('destroy', $project);

        $action($project);
    }
}
