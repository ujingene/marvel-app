<?php 

namespace App\Actions;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

/**
 * Map Api 
 */
class MarvelList
{
	public function execute($endpoint)
	{
		$apiKey = config('services.marvel.key');
		$secret = config('services.marvel.secret');
		$ts 	= Carbon::now()->toDateTimeString();
		$hash 	= md5($ts . $secret . $apiKey);

		$response = Http::get(config('services.marvel.api_url') . $endpoint, [
			'ts' 		=> $ts,
            'apikey' 	=> $apiKey,
            'hash' 		=> $hash,
            'limit'		=> 5
        ]);

        $characters = json_decode($response->body());

        return $characters;
	}
}