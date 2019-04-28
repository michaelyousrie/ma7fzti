<?php

namespace App\Helpers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

if (! function_exists('handleError')) {
    /**
     * @param  int $code
     * @param  string  $message
     * @throws HttpResponseException
     */
    function handleError(int $code, string $message = null)
    {
        $error = transformError($code, $message);
        throw new HttpResponseException(response()->json($error, $code));
    }
}

if (! function_exists('transformError')) {
    /**
     * @param int $code
     * @param string $message
     * @return array
     */
    function transformError(int $code, string $message = null)
    {
        return [
            'message' => $message ?: Response::$statusTexts[$code],
            'code' => $code
        ];
    }
}

if (! function_exists('isApiCall')) {
    /**
     * @param Request $request
     * @return bool
     */
    function isApiCall(Request $request)
    {
        return strpos($request->getUri(), '/api/') !== false;
    }
}
