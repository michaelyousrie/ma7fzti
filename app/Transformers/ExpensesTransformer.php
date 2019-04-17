<?php

namespace App\Transformers;

use App\Interfaces\TransformerInterface;

class ExpensesTransformer extends BaseTransformer
{
    protected $schema = [
        'id',
        'value' => 'amount',
        'description',
    ];
}
