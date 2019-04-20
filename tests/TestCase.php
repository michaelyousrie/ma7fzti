<?php

namespace Tests;

use App\Models\User;
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
}
