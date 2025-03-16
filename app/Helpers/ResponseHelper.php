<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function success($data, $message = 'Success', $status = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public static function error($message = 'Something went wrong', $status = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], $status);
    }
}
