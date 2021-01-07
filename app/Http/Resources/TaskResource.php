<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{

    public function toArray($request):array
    {
        return [
            'id'=>$this->id,
            'name'=> $this->name,
            'description' => $this->description,
            'complete'=> $this->complete,
            'created_at'=> $this->created_at,
            'deleted_at'=> $this->deleted_at
        ];
    }
}
