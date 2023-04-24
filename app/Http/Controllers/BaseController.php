<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public static function sendResponse($result , $message)
    {
        $response = [
         'success' => true,
         'data' => $result,
         'message' => $message,
        ];
        return response()->json($response , 200,[],JSON_UNESCAPED_SLASHES);
    }

    public static function sendError($error , $errorMessage=[] , $code = 404)
    {
        $response = [
         'success' => false,
         'data' => $error,
        ];
        if (!empty($errorMessage)) {
         $response['data'] = $errorMessage;
        }
        return response()->json($response , $code);
    }

}
