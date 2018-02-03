<?php

namespace App\Services;

use App\Exceptions\BadInputException;
use Mockery\Exception;

class KlingonTranslationService
{

    private $transliterationMap = [
        // Char table as given in the task
        'tlh' => 0xF8E4,
        'gh' => 0xF8D5,
        'ng' => 0xF8DC,
        'ch' => 0xF8D2,

        'a' => 0xF8D0,
        'b' => 0xF8D1,
        'D' => 0xF8D3,
        'e' => 0xF8D4,
        'H' => 0xF8D6,
        'I' => 0xF8D7,
        'j' => 0xF8D8,
        'l' => 0xF8D9,
        'm' => 0xF8DA,
        'n' => 0xF8DB,
        'o' => 0xF8DD,
        'p' => 0xF8DE,
        'q' => 0xF8DF,
        'Q' => 0xF8E0,
        'r' => 0xF8E1,
        'S' => 0xF8E2,
        't' => 0xF8E3,
        'u' => 0xF8E5,
        'v' => 0xF8E6,
        'w' => 0xF8E7,
        'y' => 0xF8E8,
        '’' => 0xF8E9,

        ' ' => 0x0020,
    ];

    /*
     * Char table with actual symbols
     */
    private $transliterationMapUtf;


    public function __construct()
    {
        // This table is generated dynamically but we can just predefine it as array
        foreach ($this->transliterationMap as $k => $v) {
            if ($k != 'Q') {
                $k = strtolower($k);
            }
            $this->transliterationMapUtf[$k] = unichr($v);
        }
    }


    /*
     * Return indexes of pIqaD unicode chars
     * @return string
     */
    public function engToKlingon(string $string, $isStrict = true): array
    {
        //
        $string = preg_replace_callback('/([A-PR-Z])/', function ($word) {
            return strtolower($word[1]);
        }, $string);


        $out = str_replace(array_keys($this->transliterationMapUtf),
            $this->transliterationMapUtf,
            $string
        );

        $chars = preg_split('//u', $out, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($chars as $k => $v) {
            if (!in_array($v, $this->transliterationMapUtf)) {
                if ($isStrict) {
                    throw new BadInputException();
                } else {
                    unset($chars[$k]);
                }
            }
        }

        array_values($chars);

        return $chars;
    }
}