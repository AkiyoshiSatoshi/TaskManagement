<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'status' => [
                'id' => $this->resource->status,
                'name' => $this->resource->task_status_name,
                'done' => $this->resource->status === 10 ? true : false,
            ],
            'detail' => $this->resource->detail,
            'subtasks' => SubtaskResource::collection($this->whenLoaded('subtasks')),
        ];
    }
}