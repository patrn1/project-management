<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $array = parent::toArray($request);
        $array['assignee_id'] = $this->assignee?->id;
        $array['assignee_name'] = $this->assignee?->name;
        $array['project'] = $this->project;

        return $array;
    }
}
