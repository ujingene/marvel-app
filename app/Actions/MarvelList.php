<?php 

namespace App\Actions;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * This action handle authenticates api and returns the marvel characters 
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
		try{

			$response = Http::timeout(5)->get(config('services.marvel.api_url') . $endpoint, 
			    	[
			    		'ts' 		=> $this->ts,
			    		'apikey' 	=> $this->apiKey,
			    		'hash' 		=> $this->hash
			    	]);

			// Cache the data for 1 day 
			Cache::put('marvel_characters', $response->json(), Carbon::now()->addDay());

	        return $response['data'] ?? null;
		} catch( Exception $e){
			throw new $e;
		}
	}
}