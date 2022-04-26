<?php

use App\Actions\MarvelList;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

uses(CreatesApplication::class);
uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach()->createApplication();

it('can test remote marvel address', function () {
    $api_url = config('services.marvel.api_url', 'https://gateway.marvel.com/v1/public');
    $response = Http::get($api_url);

    $this->assertEquals(404, $response->status());
});

it('can test api authentication', function () {
    $api_url = config('services.marvel.api_url', 'https://gateway.marvel.com/v1/public');
    $secret = config('services.marvel.secret');
    $apiKey = config('services.marvel.key');

    $ts = Carbon::now()->toDateTimeString();

    $hash = md5($ts . $secret . $apiKey);

    $queryString = [
        'ts' => $ts,
        'apikey' => $apiKey,
        'hash' => $hash,
        'limit' => 1
    ];

    $url = $api_url . 'characters?' . http_build_query($queryString);

    $response = Http::get($url);

    $this->assertEquals(200, $response->status());
});

it('can test successfull authentication can pull marvel characters', function () {
    $getMarvelCharacters = new MarvelList;

    $response = $getMarvelCharacters->execute($endpoint='characters');

    $this->assertEquals(200, $response->status());
    
    expect($response)->toBeArray();
});

