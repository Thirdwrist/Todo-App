<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskResourceCollection extends ResourceCollection
{
    public function toArray($request):array
    {
        return [
            'tasks'=> $this->collection
        ];
    }
}
