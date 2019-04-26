<?php

namespace App\Http\Requests;

use App\Models\IncomeCategory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UpdateIncomeCategoryRequest extends BaseRequest
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
        $incomeCategory = IncomeCategory::findOrFail( $this->id );

        return [
            'name'              => [
                "required",
                Rule::unique('income_categories', 'name')->where( function ( $query ) use ($incomeCategory) {
                    $query->where('user_id', Auth::id())->where('name', '!=', $incomeCategory->name);
                }),
            ],
            'description'      => [
                "required",
                Rule::unique('income_categories', 'description')->where( function ( $query ) use ($incomeCategory) {
                    $query->where('user_id', Auth::id())->where('description', '!=', $incomeCategory->description);
                }),
            ],
        ];
    }
}
