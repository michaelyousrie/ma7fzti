<?php

namespace Tests\Feature;

use Tests\TestCase;
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
}
