<?php 

namespace App\Actions;

use App\Exceptions\MarvelCharacterReQuestException;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
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
		$response = Http::retry(3, 500, function ($exception) {
			return $exception instanceof ConnectionException;
		})->get(config('services.marvel.api_url') . $endpoint, 
		[
    		'ts' 		=> $this->ts,
    		'apikey' 	=> $this->apiKey,
    		'hash' 		=> $this->hash
    	]);

		// Throw an exception if a server error occurred
        if ($response->serverError()) {
            throw new MarvelCharacterReQuestException('Server error', $response->status());
        }

        // Throw an exception if a client error occurred
        if ($response->clientError()) {
            switch ($response->status()) {
                case 401: $error = 'Invalid hash or referer'; break;
                case 403: $error = 'Forbidden'; break;
                case 405: $error = 'Method not allowed'; break;
                case 409: $error = 'Invalid parameters'; break;
                default: $error = 'An error occurred'; break;
            }

            throw new MarvelCharacterReQuestException($error, $response->status());
        }

        $response = [
        	'data' => $response['data'] ?? null,
        	'headers' => $response->headers(),
        	'status' => $response->status(),
        	'cookies' => $response->cookies()
        ];

		// Cache the data for 1 day 
		Cache::put('marvel_characters', $response, Carbon::now()->addDay());

        return $response;
	}
}