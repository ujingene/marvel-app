<?php 

namespace App\Actions;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * Map Api 
 */
class MarvelList
{
	public function __construct()
	{
		$this->apiKey = config('services.marvel.key');
		$this->secret = config('services.marvel.secret');
		$this->ts 	= Carbon::now()->toDateTimeString();
		$this->hash 	= md5($this->ts . $this->secret . $this->apiKey);
	}
	public function execute($endpoint)
	{
		$response = Cache::remember('marvel_characters', 300, function() use($endpoint) {
		    return Http::get(config('services.marvel.api_url') . $endpoint, [
			'ts' 		=> $this->ts,
            'apikey' 	=> $this->apiKey,
            'hash' 		=> $this->hash,
            'limit'		=> 5
        ]);
		});

        $characters = json_decode($response->body());

        return $characters;
	}
}