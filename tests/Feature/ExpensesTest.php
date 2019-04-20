<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Expense;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

        $response = $this->post( $this->makeUrl("/api/v1/expenses") , $data);

        $this->assertDatabaseHas('expenses', [
            'user_id'       => $data['user_id'],
            'category_id'   => $expenseCategory->id,
            'amount'        => $data['amount'],
            'description'   => $data['description']
        ]);
    }
}
