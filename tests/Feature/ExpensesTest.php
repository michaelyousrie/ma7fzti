<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Expense;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\ExpenseCategory;

class ExpensesTest extends TestCase
{
    use RefreshDatabase;

    
    public function testCreatingNewExpense()
    {
        $this->init();

        $expenseCategory = $this->createExpenseCategory();

        $data = factory(Expense::class)->make([
            'category_id'   => $expenseCategory->id,
            'user_id'       => $expenseCategory->user_id
        ])->toArray();

        $this->post( $this->makeUrl("/api/v1/expenses") , $data);

        $this->assertDatabaseHas('expenses', [
            'user_id'       => $data['user_id'],
            'category_id'   => $expenseCategory->id,
            'amount'        => $data['amount'],
            'description'   => $data['description']
        ]);
    }


    public function testCreatingNewExpenseValidation()
    {
        $this->init();

        $url = "/api/v1/expenses";

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


        // Test updating expense with a category id that doesn't belong to our current user.
        $otherUser = factory( User::class )->create();
        $otherExpenseCategory = factory( ExpenseCategory::class )->create([
            'user_id'       => $otherUser->id
        ]);

        $data = [
            "amount"        => 123,
            "category_id"   => $otherExpenseCategory->id,
            "description"   => "Updated Description"
        ];

        $expense = factory(Expense::class)->create([
            "user_id"   => $this->user->id
        ]);

        $response = $this->getResponse( "api/v1/user/expenses/{$expense->id}", $data, 'patch' );

        $this->assertArrayHasKey("errors", $response);

        $this->assertEquals("The selected category id is invalid.", $response['errors']->category_id[0]);
    }
}
