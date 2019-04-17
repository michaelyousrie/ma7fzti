<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Expense;

class ExpenseCategory extends Model
{
    protected $table = "expense_categories";


    public function expenses()
    {
        return $this->hasMany( Expense::class );
    }
}
