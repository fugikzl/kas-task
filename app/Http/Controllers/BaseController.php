<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\ApiResponse\Response as ApiResponse;

class BaseController extends Controller
{
    /**
     * send response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, string $message, int $code = 200)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, $code);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

    /**
     * 
     * 
     * 
     */
    public function response(ApiResponse $response)
    {
        if(!$response->isError)
        {
            return $this->sendResponse($response->result, $response->message, $response->code);
        }else{
            return $this->sendError($response->error, $response->errorMesages, $response->code);
        }
    }
}
