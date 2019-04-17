<?php

namespace App\Transformers;

class ExpensesTransformer extends BaseTransformer
{
    protected $schema = [
        'id',
        'value' => 'amount',
        'description',
    ];
}
