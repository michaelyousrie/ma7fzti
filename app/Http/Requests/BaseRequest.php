<?php

namespace App\Http\Requests;

use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $validationErrors = [];
        foreach ($errors->messages() as $errorName => $error){
            $validationErrors[$errorName] = $error[0];
        }
        throw new HttpResponseException(response()->json(
            [ 'errors'   => $validationErrors ]
            , Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
