<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{

    public function toArray($request):array
    {
        return [
            'id'=>$this->id,
//            /
        ];
    }
}