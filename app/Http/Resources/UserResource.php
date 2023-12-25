<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $array = parent::toArray($request);

        $array['id'] = $this->id;
        $array['name'] = $this->name;
        $array['email'] = $this->email;

        return $array;
    }
}
