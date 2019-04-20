<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Income;
use App\Models\IncomeCategory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IncomesTest extends TestCase
{
    use RefreshDatabase;

    public function testCreatingNewIncome()
    {
        $this->init();

        $incomeCategory = $this->createIncomeCategory();

        $data = factory(Income::class)->make([
            'category_id'   => $incomeCategory->id,
            'user_id'       => $incomeCategory->user_id
        ])->toArray();

        $this->post( $this->makeUrl("/api/v1/incomes") , $data);

        $this->assertDatabaseHas('incomes', [
            'user_id'       => $data['user_id'],
            'category_id'   => $incomeCategory->id,
            'amount'        => $data['amount'],
            'description'   => $data['description']
        ]);
    }


    public function testCreatingNewIncomeValidation()
    {
        $this->init();

        $url = "/api/v1/incomes";

        // Test empty values
        $data = [];

        $response = $this->getResponse($url, $data);

        $this->assertArrayHasKey("errors", $response);

        $this->assertEquals("The amount field is required.", $response['errors']->amount[0]);
        $this->assertEquals("The category id field is required.", $response['errors']->category_id[0]);
        $this->assertEquals("The description field is required.", $response['errors']->description[0]);


        // Test wrong values
        $data = [
            "amount"        => "TEST",
            "category_id"   => 1,
            "description"   => "Hello"
        ];

        $response = $this->getResponse($url, $data);

        $this->assertArrayHasKey("errors", $response);

        $this->assertEquals("The amount must be a number.", $response['errors']->amount[0]);
        $this->assertEquals("The selected category id is invalid.", $response['errors']->category_id[0]);


        // Test updating income with a category id that doesn't belong to our current user.
        $otherUser = factory( User::class )->create();
        $otherIncomeCategory = factory( IncomeCategory::class )->create([
            'user_id'       => $otherUser->id
        ]);

        $data = [
            "amount"        => 123,
            "category_id"   => $otherIncomeCategory->id,
            "description"   => "Updated Description"
        ];

        $income = factory(Income::class)->create([
            "user_id"   => $this->user->id
        ]);

        $response = $this->getResponse( "api/v1/user/incomes/{$income->id}", $data, 'patch' );

        $this->assertArrayHasKey("errors", $response);

        $this->assertEquals("The selected category id is invalid.", $response['errors']->category_id[0]);
    }

}
