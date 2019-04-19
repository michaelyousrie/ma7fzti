<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'amount', 'category_id', 'description'
    ];


    public function category()
    {
        return $this->belongsTo( ExpenseCategory::class );
    }
}
