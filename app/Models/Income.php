<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Providers\BalanceGotUpdated;

class Income extends Model
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
        return $this->belongsTo( IncomeCategory::class );
    }
}
