<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetCharacterTest extends TestCase
{
    // If we see non 0 status then it's fail right away
    // Otherwise return output
    public function artisanRead($cmd, $params)
    {
        $outputCode = Artisan::call($cmd, $params);
        $this->assertEquals($outputCode, 0);
        // we have a new line symbol so trim it
        return trim(Artisan::output());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $result = $this->artisanRead("star-trek:get-character", ["name" => 'Uhura']);
        $this->assertEquals("0xF8E5 0xF8D6 0xF8E5 0xF8E1 0xF8D0\nHuman", $result);

        // 19 chars
        $result = $this->artisanRead("star-trek:get-character", ["name" => 'Van der Waals ghost']);
        // 18 chars, empty line for the race
        $this->assertEquals("0xF8E6 0xF8D0 0xF8DB 0x0020 0xF8D3 0xF8D4 0xF8E1 0x0020 0xF8E7 0xF8D0 0xF8D0 0xF8D9 0xF8E2 0x0020 0xF8D5 0xF8DD 0xF8E2 0xF8E3", $result);


        $result = $this->artisanRead("star-trek:get-character", ["name" => 'Q']);
        $this->assertEquals("0xF8E0\nQ", $result);
    }
}
