<?php

namespace Tests;

use App\Actions\MarvelList;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->api_url = 'https://gateway.marvel.com/v1/public';

        Http::fake([
            // Stub a JSON response for GitHub endpoints...
            'gateway.marvel.*' => Http::response(
                [
                    "offset" => 0,
                    "limit" => 20,
                    "total" => 1561,
                    "count" => 20,
                    "results" => [
                        [
                          "id" => 1011334,
                          "name" => "3-D Man",
                          "description" => "",
                          "modified" => "2014-04-29T14:18:17-0400",
                          "thumbnail" => [
                            "path" => "http://i.annihil.us/u/prod/marvel/i/mg/c/e0/535fecbbb9784",
                            "extension" => "jpg"
                          ],
                          "resourceURI" => "http://gateway.marvel.com/v1/public/characters/1011334",
                          "comics" => [],
                          "series" => [],
                          "stories" => [],
                          "events" => [],
                          "urls" => [],
                        ], 
                    ],
                ], 200
            ),
        ]);

        Excel::fake();

        $this->marvelist = new MarvelList;
    }
}
