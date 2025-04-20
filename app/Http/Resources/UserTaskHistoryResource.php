<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserTaskHistoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_name' => optional($this->user)->name,
            'task_name' => optional($this->task)->name,
            'started_at' => $this->created_at?->toIso8601String(),
            'ended_at' => $this->completed_at?->toIso8601String(),
        ];
    }
}
