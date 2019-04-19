<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "first_name"        => 'required|string',
            "last_name"         => 'required|string',
            "email"             => 'required|email|unique:users,email',
            "password"          => 'required|min:5',
            "currency"          => "required|max:3",
            "language_code"     => "required|exists:languages,code"
        ];
    }
}
