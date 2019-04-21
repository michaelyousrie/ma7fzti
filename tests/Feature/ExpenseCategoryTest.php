<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\ExpenseCategory;

class ExpenseCategoryTest extends TestCase
{
    use RefreshDatabase;


    public function testGettingAllExpenseCategories()
    {
        $this->init();

        factory( ExpenseCategory::class, 10 )->create([
            "user_id" => $this->user->id
        ]);

        $categories = ExpenseCategory::all();

        $cats = [];

        foreach( $categories as $cat ) {
            $cats[] = $cat->id;
        }

        $catss = $this->getResponse("/api/v1/user/expense_categories", [], "get")['data'];

        foreach( $catss as $cat ) {
            $this->assertTrue( in_array($cat->id, $cats) );
        }
    }


    public function testViewIndividualExpenseCategory()
    {
        $this->init();

        $category = factory( ExpenseCategory::class )->create([
            'user_id'   => $this->user->id
        ]);

        $response = $this->getResponse("/api/v1/user/expense_categories/{$category->id}", [], "get")['data'];

        $this->assertEquals( $response->id, $category->id );
        $this->assertEquals( $response->name, $category->name );
        $this->assertEquals( $response->description, $category->description );
    }
}
