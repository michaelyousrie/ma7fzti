<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Language;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class GeneralTest extends TestCase
{
    use RefreshDatabase;


    public function testSendingARequestWithoutApiTokenFails()
    {
        $resp = $this->get('/api/v1/languages');

        $this->assertEquals($resp->status(), 403);
    }


    public function testSendingRequestToLoginAndRegisterWithoutApiTokenWorks()
    {
        $resp = $this->post('/api/v1/login');

        $this->assertTrue( $resp->status() != 403 );

        $resp = $this->post('/api/v1/register');

        $this->assertTrue( $resp->status() != 403 );
    }


    public function testRegistration()
    {
        $language = factory(Language::class)->create();

        $data = [
            'first_name'    => "Test",
            "last_name"     => "Testt",
            "email"         => "test@test.com",
            "password"      => "password",
            "currency"      => "EGP",
            "language_code" => $language->code
        ];

        $resp = (array) json_decode( $this->post( "/api/v1/register", $data )->getContent() );

        $this->assertArrayHasKey("data", $resp);

        $id = $resp['data']->id;

        $this->assertDatabaseHas('users', [
            "first_name"        => "Test",
            "last_name"         => "Testt",
            "id"                => $id
        ]);
    }


    public function testLogin()
    {
        $user = factory( User::class )->create();

        $data = [
            "email"     => $user->email,
            "password"  => "password"
        ];

        $resp = (array) json_decode( $this->post( "/api/v1/login", $data )->getContent() );

        $this->assertArrayHasKey("data", $resp);

        $resp = $resp['data'];

        $this->assertEquals( $user->id, $resp->id );
        $this->assertEquals( $user->first_name, $resp->first_name );
        $this->assertEquals( $user->last_name, $resp->last_name );
    }
}
