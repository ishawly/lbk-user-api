<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    public function success($data, $message = 'success', $status = Response::HTTP_OK)
    {
        return \response()->json([
            'code'    => 0,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    public function failed($message, $status = Response::HTTP_BAD_REQUEST)
    {
        return \response()->json([
            'code'    => $status,
            'message' => $message,
        ], $status);
    }

    public function deleted()
    {
        return \response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
