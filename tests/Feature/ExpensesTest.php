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


    public function testGettingUserExpenses()
    {
        $this->init();

        $expenses = factory(Expense::class, 10)->create([
            'user_id'       => $this->user->id
        ]);

        $expenses = Expense::all();

        $exps = [];

        foreach ( $expenses as $exp ) {
            $exps[] = $exp->id;
        }

        $currentExpenses = $this->getResponse( "/api/v1/user/expenses", [], 'get' )['data'];

        foreach( $currentExpenses as $exp ) {
            $this->assertTrue( in_array($exp->id, $exps) );
        }
    }


    public function testUpdatingExpense()
    {
        $this->init();

        $expenseCategory = factory(ExpenseCategory::class)->create([
            "user_id"   => $this->user->id
        ]);

        $expense = factory(Expense::class)->create([
            "user_id"       => $this->user->id,
            "category_id"   => $expenseCategory->id 
        ]);

        $data = [
            "amount"        => 123.45,
            "description"   => "Test Description",
            "category_id"   => $expense->category_id
        ];

        $this->getResponse("/api/v1/user/expenses/{$expense->id}", $data, 'patch');

        $expense = Expense::find($expense->id);

        $this->assertEquals(123.45, $expense->amount);
        $this->assertEquals("Test Description", $expense->description);
    }


    public function testUpdatingExpenseValidation()
    {
        $this->init();

        $expenseCategory = factory(ExpenseCategory::class)->create([
            "user_id"   => $this->user->id
        ]);

        $expense = factory(Expense::class)->create([
            "user_id"       => $this->user->id,
            "category_id"   => $expenseCategory->id 
        ]);

        // Assert updating expense category_id with a category id that doesn't belong to the current user fails.
        $otherExpenseCategory = factory(ExpenseCategory::class)->create();

        $data = [
            "category_id"   => $otherExpenseCategory->id,
            "amount"        => 123.34,
            "description"   => "Should Fail."
        ];

        $response = $this->getResponse("/api/v1/user/expenses/{$expense->id}", $data, 'patch');
        
        $this->assertArrayHasKey("errors", $response);

        $this->assertEquals("The selected category id is invalid.", $response['errors']->category_id[0]);


        // Assert using invalid category_id fails
        $data = [
            "category_id"   => 999,
            "amount"        => 123.34,
            "description"   => "Should Fail."
        ];

        $response = $this->getResponse("/api/v1/user/expenses/{$expense->id}", $data, 'patch');
        
        $this->assertArrayHasKey("errors", $response);

        $this->assertEquals("The selected category id is invalid.", $response['errors']->category_id[0]);


        // Assert using invalid amount fails.
        $data = [
            "category_id"   => $otherExpenseCategory->id,
            "amount"        => "hehe",
            "description"   => "Should Fail."
        ];

        $response = $this->getResponse("/api/v1/user/expenses/{$expense->id}", $data, 'patch');
        
        $this->assertArrayHasKey("errors", $response);

        $this->assertEquals("The amount must be a number.", $response['errors']->amount[0]);

        // Assert missing amount value fails.
        $data = [
            "category_id"   => $otherExpenseCategory->id,
            "description"   => "Should Fail."
        ];

        $response = $this->getResponse("/api/v1/user/expenses/{$expense->id}", $data, 'patch');
        
        $this->assertArrayHasKey("errors", $response);

        $this->assertEquals("The amount field is required.", $response['errors']->amount[0]);
    }
}
