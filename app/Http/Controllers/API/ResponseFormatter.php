<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResponseFormatter extends Controller
{
    protected static $response = [
        "meta" => [
            "code" => 200,
            "status" => "success",
            "message" => null    
        ],
        "data" => null
    ];

    public static function success($data = null, $message = null, $code = 200)
    {
        self::$response["meta"]["code"] = $code;
        self::$response["meta"]["message"] = $message;
        self::$response["data"] = $data;

        return response()->json(self::$response, $code);
    }

    public static function error($message = null, $code = 400)
    {
        self::$response["meta"]["status"] = "error";
        self::$response["meta"]["code"] = $code;
        self::$response["meta"]["message"] = $message;

        return response()->json(self::$response, $code);
    }
}
