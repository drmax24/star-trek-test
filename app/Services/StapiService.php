<?php

namespace App\Services;

use GuzzleHttp;

class StapiService
{
    public function getCharacter($searchString)
    {
        $nevskyApiEndpoint = 'http://stapi.co/api/v1/rest/character/search';
        $client = new GuzzleHttp\Client();
        $res = $client->post($nevskyApiEndpoint, [
            'post' => ['name' => $searchString]
        ]);

        $statusCode = $res->getStatusCode(); // 200
        $body = json_decode((string)$res->getBody());

        return $body;
    }
}