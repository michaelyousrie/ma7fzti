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


    public function testUpdatingIncomeCategory()
    {
        $this->init();

        $cat = factory( IncomeCategory::class )->create([
            'user_id'   => $this->user->id
        ]);

        // Test valid data
        $data = [
            'name'          => "Test Name",
            'description'   => "Test Description"
        ];

        $response = $this->getResponse("/api/v1/user/income_categories/{$cat->id}", $data, 'patch');

        $this->assertArrayHasKey("data", $response);

        $this->assertEquals("Test Name", $response['data']->name);
        $this->assertEquals("Test Description", $response['data']->description);

        $cat = IncomeCategory::find( $cat->id );

        $this->assertEquals("Test Name", $cat->name);
        $this->assertEquals("Test Description", $cat->description);


        // Test updating only name
        $data = [
            'name'          => "Test Name2",
            'description'   => "Test Description"
        ];

        $response = $this->getResponse("/api/v1/user/income_categories/{$cat->id}", $data, 'patch');

        $this->assertArrayHasKey("data", $response);

        $this->assertEquals("Test Name2", $response['data']->name);
        $this->assertEquals("Test Description", $response['data']->description);

        $cat = IncomeCategory::find( $cat->id );

        $this->assertEquals("Test Name2", $cat->name);
        $this->assertEquals("Test Description", $cat->description);


        // Test invalid data
        $otherCat = factory(IncomeCategory::class)->create([
            'user_id'   => $this->user->id
        ]);

        $data = [
            'name'          => $otherCat->name,
            'description'   => $otherCat->description
        ];

        $response = $this->getResponse("/api/v1/user/income_categories/{$cat->id}", $data, 'patch');

        $this->assertArrayHasKey("errors", $response);

        $this->assertEquals( "The name has already been taken.", $response['errors']->name[0] );
        $this->assertEquals( "The description has already been taken.", $response['errors']->description[0] );
    }
}
