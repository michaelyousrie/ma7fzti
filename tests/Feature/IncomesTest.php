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


    public function testUpdatingIncome()
    {
        $this->init();

        $incomeCategory = factory(IncomeCategory::class)->create([
            "user_id"   => $this->user->id
        ]);

        $income = factory(Income::class)->create([
            "user_id"       => $this->user->id,
            "category_id"   => $incomeCategory->id 
        ]);

        $data = [
            "amount"        => 123.45,
            "description"   => "Test Description",
            "category_id"   => $income->category_id
        ];

        $this->getResponse("/api/v1/user/incomes/{$income->id}", $data, 'patch');

        $income = Income::find($income->id);

        $this->assertEquals(123.45, $income->amount);
        $this->assertEquals("Test Description", $income->description);
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


    public function testUpdatingIncomeValidation()
    {
        $this->init();

        $incomeCategory = factory(IncomeCategory::class)->create([
            "user_id"   => $this->user->id
        ]);

        $income = factory(Income::class)->create([
            "user_id"       => $this->user->id,
            "category_id"   => $incomeCategory->id 
        ]);

        // Assert updating income category_id with a category id that doesn't belong to the current user fails.
        $otherIncomeCategory = factory(IncomeCategory::class)->create();

        $data = [
            "category_id"   => $otherIncomeCategory->id,
            "amount"        => 123.34,
            "description"   => "Should Fail."
        ];

        $response = $this->getResponse("/api/v1/user/incomes/{$income->id}", $data, 'patch');
        
        $this->assertArrayHasKey("errors", $response);

        $this->assertEquals("The selected category id is invalid.", $response['errors']->category_id[0]);


        // Assert using invalid category_id fails
        $data = [
            "category_id"   => 999,
            "amount"        => 123.34,
            "description"   => "Should Fail."
        ];

        $response = $this->getResponse("/api/v1/user/incomes/{$income->id}", $data, 'patch');
        
        $this->assertArrayHasKey("errors", $response);

        $this->assertEquals("The selected category id is invalid.", $response['errors']->category_id[0]);


        // Assert using invalid amount fails.
        $data = [
            "category_id"   => $otherIncomeCategory->id,
            "amount"        => "hehe",
            "description"   => "Should Fail."
        ];

        $response = $this->getResponse("/api/v1/user/incomes/{$income->id}", $data, 'patch');
        
        $this->assertArrayHasKey("errors", $response);

        $this->assertEquals("The amount must be a number.", $response['errors']->amount[0]);

        // Assert missing amount value fails.
        $data = [
            "category_id"   => $otherIncomeCategory->id,
            "description"   => "Should Fail."
        ];

        $response = $this->getResponse("/api/v1/user/incomes/{$income->id}", $data, 'patch');
        
        $this->assertArrayHasKey("errors", $response);

        $this->assertEquals("The amount field is required.", $response['errors']->amount[0]);
    }


    public function testGettingAllUserIncomes()
    {
        $this->init();

        $incomes = factory( Income::class, 10 )->create([
            'user_id'   => $this->user->id
        ]);

        $incomes = Income::all();
        
        $incs = [];

        foreach( $incomes as $inc ) {
            $incs[] = $inc->id;
        }

        $incomes = $this->getResponse("/api/v1/user/incomes", [], "get")['data']->incomes;

        foreach( $incomes as $income ) {
            $this->assertTrue( in_array($income->id, $incs) );
        }
    }


    public function testViewingIndividualIncome()
    {
        $this->init();

        $item = factory( Income::class )->create([
            'user_id'   => $this->user->id
        ]);

        $response = $this->getResponse("/api/v1/user/incomes/{$item->id}", [], "get")['data']->income;

        $this->assertEquals( $response->id, $item->id );
        $this->assertEquals( $response->amount, $item->amount );
        $this->assertEquals( $response->description, $item->description );
    }
}
