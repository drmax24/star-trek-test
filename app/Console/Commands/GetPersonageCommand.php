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
    protected $signature = 'star-trek:get-personage {name} {--debug-sapi}';

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
        $translationService = new  KlingonTranslationService();
        $plaqdNameChars = $translationService->engToKlingon($this->argument('name'));

        $charCount = count($plaqdNameChars);
        foreach ($plaqdNameChars as $k => $v) {
            $out .= '0x' . dechex(unicode_keys($v));
            if ($k < $charCount - 1) {
                $out .= ' ';
            }
        }
        $out .= "\n";


        $sapiService = new  StapiService();
        $character = $sapiService->getCharacter($this->argument('name'));


        if (!$this->option('debug-sapi')) {
            if (isset($character['characterSpecies'][0]['name'])) {
                $out .= $character['characterSpecies'][0]['name'];
            }
        } else {
            $out .= print_r($character, true);
        }


        $out .= "\n";

        echo $out;
    }
}
