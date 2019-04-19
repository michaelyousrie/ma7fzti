<?php

namespace App\Http\Requests;

class CreateIncomeRequest extends BaseRequest
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
            'category_id'   => 'required|exists:expenses,id',
            'description'   => 'required'
        ];
    }
}
