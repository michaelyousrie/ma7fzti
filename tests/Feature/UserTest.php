<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;


    public function testUpdatingUser()
    {
        $this->init();

        $user = $this->user;

        // Test using valid data
        $data = [
            "email"         => "test@test.com",
            "first_name"    => "FirstName",
            "last_name"     => "LastName",
            "password"      => "password",
            "currency"      => $user->currency,
            "language_code" => $user->language_code
        ];

        $response = $this->getResponse("/api/v1/user", $data, "patch");

        $user = User::find( $user->id );

        $this->assertTrue( array_key_exists('data', $response) );

        foreach( $response['data'] as $key => $value ) {
            $this->assertEquals( $user->$key, $value );
        }

        // Test using invalid data

        // test using an email that belongs to another user.
        $otherUser = factory(User::class)->create();

        $data = [
            "email"         => $otherUser->email,
            "first_name"    => $user->first_name,
            "last_name"     => $user->last_name,
            "password"      => "password",
            "currency"      => $user->currency,
            "language_code" => $user->language_code
        ];

        $response = $this->getResponse("/api/v1/user", $data, "patch");

        $this->assertArrayHasKey("errors", $response);
        $this->assertTrue( property_exists($response['errors'], 'email') );

        $this->assertEquals("The email has already been taken.", $response['errors']->email[0]);
    }
}
