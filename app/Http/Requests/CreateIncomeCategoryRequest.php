<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class CreateIncomeCategoryRequest extends BaseRequest
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
        $userId = Auth::id();

        return [
            'name'              => 'required|string|unique:income_categories,name,NULL,id,user_id,'.$userId,
            'description'       => 'required|string|unique:income_categories,description,NULL,id,user_id,'.$userId,
        ];
    }
}
