<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Language;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LanguagesTest extends TestCase
{
    use RefreshDatabase;


    public function testGettingAllLanguages()
    {
        $this->init();

        $languages = factory(Language::class, 2)->create()->toArray();

        $languages = Language::all();

        $langs = [];

        foreach ( $languages as $lang ) {
            $langs[] = $lang['code'];
        }

        $response = $this->getResponse("/api/v1/languages", [], 'get')['data'];

        foreach( $response as $resp ) {
            $this->assertTrue( in_array($resp->code, $langs) );
        }
    }
}
