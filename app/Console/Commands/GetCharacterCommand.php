<?php

namespace App\Console\Commands;

use App\Services\StapiService;
use Illuminate\Console\Command;
use App\Services\KlingonTranslationService;

class GetCharacterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'star-trek:get-character {name} {--strict-transliteration} {--debug-sapi}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Outputs translated name and the species name separated by a new line.';

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
        $plaqdNameChars = $translationService->engToKlingon(
            $this->argument('name'),
            $this->option('strict-transliteration'
            ));

        $charCount = count($plaqdNameChars);
        foreach ($plaqdNameChars as $k => $v) {
            $hexRepresentation = strtoupper(dechex(unicode_keys($v)));
            if (strlen($hexRepresentation) == 3) {
                $hexRepresentation = '0'.$hexRepresentation;
            }
            if (strlen($hexRepresentation) == 2) {
                $hexRepresentation = '00'.$hexRepresentation;
            }
            $hexRepresentation = '0x'.$hexRepresentation;

            $out .= $hexRepresentation;
            if ($k < $charCount - 1) {
                $out .= ' ';
            }
        }
        $out .= "\n";

        // stapi -------------------------------------------
        $sapiService = new  StapiService();
        $character = $sapiService->getCharacter($this->argument('name'));


        if (!$this->option('debug-sapi')) {
            if (isset($character['characterSpecies'][0]['name'])) {
                $out .= $character['characterSpecies'][0]['name'];
            }
        } else {
            $out .= print_r($character, true);
        }


        $this->line($out);
    }
}
