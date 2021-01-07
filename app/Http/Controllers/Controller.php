<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function response(int $statusCode, string $message,  $data = []) :JsonResponse
    {
        $response = [
            'status'=> Response::$statusTexts[$statusCode],
            'message' => $message
        ];
        if($data)
        {
            $response['data']= $data;
        }

        return response()->json($response, $statusCode);
    }
}
