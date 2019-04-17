<?php

namespace App\Transformers;

class LanguagesTransformer extends BaseTransformer
{
    protected $schema = [
        'id',
        'code',
        'name'
    ];
}
