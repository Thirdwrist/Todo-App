<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray($request) :array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->description,
            'created_at'=>$this->created_at->diffForHumans(),
            'deleted_at'=>optional($this->deleted_at)->diffForHumans(),
            'tasks'=>TaskResource::collection($this->tasks),
            'user'=>new UserResource($this->user)
        ];
    }
}
