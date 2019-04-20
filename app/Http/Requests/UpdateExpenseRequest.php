<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateExpenseRequest extends BaseRequest
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
            'amount'        => 'required|numeric|between:1,999999999999.99',
            'category_id'   => [
                'required',
                Rule::exists('expense_categories', 'id')->where(function( $query ) {
                    $query->where('user_id', Auth::id());
                }),
            ],
            'description'   => 'required'
        ];
    }
}
