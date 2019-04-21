<?php

namespace Tests;

use App\Models\User;
use App\Models\IncomeCategory;
use App\Models\ExpenseCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $token;
    protected $user;

    protected function createUser()
    {
        return factory( User::class )->create();
    }


    protected function createExpenseCategory()
    {
        return factory( ExpenseCategory::class )->create([
            'user_id'       => $this->user->id
        ]);
    }


    protected function createIncomeCategory()
    {
        return factory( IncomeCategory::class )->create([
            'user_id'       => $this->user->id
        ]);
    }

    
    protected function makeUrl( string $url )
    {
        return $url . '?api_token=' . $this->token;
    }


    protected function init()
    {
        $this->user = $this->createUser();
        $this->token = $this->user->api_token;

        return True;
    }


    protected function getResponse( string $url, array $data, string $method = "post" )
    {
        $resp = $this->$method( $this->makeUrl( $url ) , $data);

        if ( property_exists($resp, 'exception') ) {
            dd( $resp->exception(), $resp->status() );
        }

        $decoded = (array) json_decode( $resp->getContent() );

        // Uncomment if you think the tested url sends back errors.
        // It's commented because some test functions expect errors to be sent back.
        // if ( array_key_exists("errors", $decoded) ) {
        //     dd( $url, $decoded['errors'] );
        // }

        return $decoded;
    }
}
