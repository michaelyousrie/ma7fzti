<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\ExpenseCategory;

class Expense extends Model
{
    protected $fillable = [
        'amount', 'category_id', 'description'
    ];


    public function category()
    {
        return $this->belongsTo( ExpenseCategory::class );
    }
}
