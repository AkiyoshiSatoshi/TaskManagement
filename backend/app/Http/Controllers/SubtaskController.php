<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Subtask\UpdateRequest;
use App\Http\Resources\SubtaskResource;
use App\Models\Subtask;
use App\Models\Task;
use App\UseCases\Subtask\DestroyAction;
use App\UseCases\Subtask\ShowAction;
use App\UseCases\Subtask\StoreAction;
use App\UseCases\Subtask\UpdateAction;

class SubtaskController extends Controller
{
    public function store(Task $task, StoreAction $action): SubtaskResource
    {
        return new SubtaskResource($action($task));
    }

    public function show(Subtask $subtask, ShowAction $action): SubtaskResource
    {
        return new SubtaskResource($action($subtask));
    }

    public function update(UpdateRequest $request, Subtask $subtask, UpdateAction $action): SubtaskResource
    {
        $subtask = $request->makeSubtask($subtask);

        return new SubtaskResource($action($subtask));
    }

    public function destroy(Subtask $subtask, DestroyAction $action): void
    {
        $action($subtask);
    }
}
