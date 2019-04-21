<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\IncomeCategory;

class IncomeCategoryTest extends TestCase
{
    use RefreshDatabase;


    public function testGettingAllIncomeCategories()
    {
        $this->init();

        factory( IncomeCategory::class, 10 )->create([
            "user_id" => $this->user->id
        ]);

        $categories = IncomeCategory::all();

        $cats = [];

        foreach( $categories as $cat ) {
            $cats[] = $cat->id;
        }

        $catss = $this->getResponse("/api/v1/user/income_categories", [], "get")['data'];

        foreach( $catss as $cat ) {
            $this->assertTrue( in_array($cat->id, $cats) );
        }
    }


    public function testViewIndividualIncomeCategory()
    {
        $this->init();

        $category = factory( IncomeCategory::class )->create([
            'user_id'   => $this->user->id
        ]);

        $response = $this->getResponse("/api/v1/user/income_categories/{$category->id}", [], "get")['data'];

        $this->assertEquals( $response->id, $category->id );
        $this->assertEquals( $response->name, $category->name );
        $this->assertEquals( $response->description, $category->description );
    }
}
