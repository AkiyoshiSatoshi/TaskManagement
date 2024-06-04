<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Http\Requests\Task\UpdateStatusRequest;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use App\UseCases\Task\DestroyAction;
use App\UseCases\Task\IndexAction;
use App\UseCases\Task\ShowAction;
use App\UseCases\Task\StoreAction;
use App\UseCases\Task\UpdateAction;
use App\UseCases\Task\UpdateStatusAction;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskController extends Controller
{
    public function index(Project $project, IndexAction $action): ResourceCollection
    {
        return TaskResource::collection($action($project));
    }

    public function store(StoreRequest $request, Project $project, StoreAction $action): TaskResource
    {
        $task = $request->makeTask();
        $task->project_id = $project->id;

        return new TaskResource($action($task));
    }

    public function show(Task $task, ShowAction $action): TaskResource
    {
        return new TaskResource($action($task));
    }

    public function update(UpdateRequest $request, Task $task, UpdateAction $action): TaskResource
    {
        $task = $request->makeTask($task);

        return new TaskResource($action($task));
    }

    public function destroy(Task $task, DestroyAction $action): void
    {
        $action($task);
    }

    public function status(UpdateStatusRequest $request, Task $task, UpdateStatusAction $action): TaskResource
    {
        $task = $request->makeTask($task);

        return new TaskResource($action($task));
    }
}
