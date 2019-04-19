<?php

namespace App\Transformers;

use Illuminate\Support\Collection;

class BaseTransformer
{
    protected $data;


    public function __construct( Collection $values )
    {
        $data = [];

        foreach( $values as $value )
        {
            $temp = [];

            foreach( $this->schema as $key => $converted )
            {
                if ( is_int( $key ) ) $key = $converted;

                $temp[$key] = $value->$converted;
            }

            $data[] = $temp;
        }

        $this->data = $data;
    }


    public function transform()
    {
        return $this->data;
    }
}
