<?php

namespace App\Services;

use GuzzleHttp;

class StapiService
{
    public function getCharacter($searchString)
    {
        $apiEndpoint = 'http://stapi.co/api/v1/rest/character/search';
        $client = new GuzzleHttp\Client();
        $res = $client->post($apiEndpoint, [
            'form_params' => ['name' => $searchString, 'title' => $searchString]
        ]);

        if ($res->getStatusCode() !== 200) {
            throw new \Exception('sapi.io returned a bad status');
        }
        $characters = json_decode((string)$res->getBody(), true);
        if (!isset($characters['characters'])) {
            throw new \Exception('sapi.io result is malformed');
        }

        // Getting details for each search result until we get species
        foreach ($characters['characters'] as $v) {
            if(!isset($v['uid'])) continue;
            $apiEndpoint = 'http://stapi.co/api/v1/rest/character?uid='.$v['uid'];
            $res = $client->get($apiEndpoint);


            if ($res->getStatusCode() !== 200) {
                throw new \Exception('sapi.io returned a bad status');
            }
            $body = json_decode((string)$res->getBody(), true);



            if (isset($body['character']['characterSpecies'][0]['name'])) {

                return $body['character'];
            } else {
                continue;
            }
        }


        return null;
    }
}