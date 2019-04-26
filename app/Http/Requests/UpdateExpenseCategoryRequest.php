<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\ExpenseCategory;

class UpdateExpenseCategoryRequest extends BaseRequest
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
        $expenseCategory = ExpenseCategory::findOrFail( $this->id );

        return [
            'name'              => [
                "required",
                Rule::unique('expense_categories', 'name')->where( function ( $query ) use ($expenseCategory) {
                    $query->where('user_id', Auth::id())->where('name', '!=', $expenseCategory->name);
                }),
            ],
            'description'      => [
                "required",
                Rule::unique('expense_categories', 'description')->where( function ( $query ) use ($expenseCategory) {
                    $query->where('user_id', Auth::id())->where('description', '!=', $expenseCategory->description);
                }),
            ],
        ];
    }
}
