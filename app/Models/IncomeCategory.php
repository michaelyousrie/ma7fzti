<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeCategory extends Model
{
    protected $table = "income_categories";

    protected $fillable = [
        'name', 'description'
    ];


    public function getIncomes()
    {
        return Income::where( 'category_id', $this->id )->get();
    }
}
