<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjectResourceCollection extends ResourceCollection
{
    public function toArray($request):array
    {
        return [
            'projects'=> $this->collection
        ];
    }
}
