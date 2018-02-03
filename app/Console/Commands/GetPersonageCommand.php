<?php

namespace App\Console\Commands;

use App\Services\StapiService;
use Illuminate\Console\Command;
use App\Services\KlingonTranslationService;

class GetPersonage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'star-trek:get-personage {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $out = '';
        $plaqdNameChars = (new  KlingonTranslationService())->engToKlingon($this->argument('name'));
        $charCount = count($plaqdNameChars);
        foreach ($plaqdNameChars as $k => $v) {
            $out .= '0x' . dechex(unicode_keys($v));
            if ($k < $charCount - 1) {
                $out .= ' ';
            }
        }
        $out .= "\n";

        $character = (new  StapiService())->getCharacter($this->argument('name'));
        if (isset($character->species)) {
            $out .= $character->species;
        }


        $out .= "\n";

        echo $out;
    }
}
