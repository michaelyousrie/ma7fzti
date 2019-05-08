<?php

namespace App\Models;

use App\Models\ExpenseCategory;

use App\Providers\BalanceGotUpdated;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'amount', 'category_id', 'description'
    ];

    protected $dispatchesEvents = [
        'created'       => BalanceGotUpdated::class,
        'updated'       => BalanceGotUpdated::class,
        'saved'         => BalanceGotUpdated::class,
        'deleted'       => BalanceGotUpdated::class,
        'forceDeleted'  => BalanceGotUpdated::class,
        'restored'      => BalanceGotUpdated::class,
    ];


    public function category()
    {
        return $this->belongsTo( ExpenseCategory::class );
    }
}
