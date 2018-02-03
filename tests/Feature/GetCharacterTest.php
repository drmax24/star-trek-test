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
        $this->assertEquals("0xf8e5 0xf8d6 0xf8e5 0xf8e1 0xf8d0\nHuman", $result);

        // 19 chars
        $result = $this->artisanRead("star-trek:get-character", ["name" => 'Van der Waals ghost']);
        // 18 chars, empty line for the race
        $this->assertEquals("0xf8e6 0xf8d0 0xf8db 0x0020 0xf8d3 0xf8d4 0xf8e1 0x0020 0xf8e7 0xf8d0 0xf8d0 0xf8d9 0xf8e2 0x0020 0xf8d5 0xf8dd 0xf8e2 0xf8e3", $result);
    }
}
