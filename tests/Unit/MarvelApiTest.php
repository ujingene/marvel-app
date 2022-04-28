<?php

use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;

it('can test remote marvel address', function () {
    $response = Http::get($this->api_url);

    $this->assertEquals(200, $response->status());
});

it('can test api authentication', function () {
    $response = Http::retry(3, 500, function ($exception) {
        return $exception instanceof ConnectionException;
    })->get($this->api_url, 
    [
        'ts'        => Carbon::now()->toDateTimeString(),
        'apikey'    => 'jkdf489yusdfci93jksbdfs093',
        'hash'      => '93485zjT487583039jdnf948nj'
    ]);

    $this->assertEquals(200, $response->status());
});

it('can test successfull authentication can pull marvel characters', function () {
    $response = Http::retry(3, 500, function ($exception) {
        return $exception instanceof ConnectionException;
    })->get($this->api_url, 
    [
        'ts'        => Carbon::now()->toDateTimeString(),
        'apikey'    => 'jkdf489yusdfci93jksbdfs093',
        'hash'      => '93485zjT487583039jdnf948nj'
    ]);

    $this->assertEquals(200, $response->status());
    
    expect($response['results'])->toBeArray();
});

