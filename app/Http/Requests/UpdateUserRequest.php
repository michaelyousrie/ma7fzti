<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends BaseRequest
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
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'email'         => [
                'required', 'email',
                Rule::unique('users','email')->where(function( $query ) {
                    $query->where('id', '!=', Auth::id());
                }),
            ],
            "password"          => 'required|min:5',
            "language_code"     => "required|exists:languages,code",
            "currency"          => "required|max:3",
        ];
    }
}
