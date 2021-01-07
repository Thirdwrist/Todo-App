<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResourceCollection;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class UserController extends Controller
{
    public function projects(User $user) :JsonResponse
    {
        return $this->response(
            Response::HTTP_OK,
            'success',
            new ProjectResourceCollection($user->projects)
        );
    }
}
