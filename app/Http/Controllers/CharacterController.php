<?php

namespace App\Http\Controllers;

use App\Actions\MarvelList;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CharacterController extends Controller
{
    public function __construct(MarvelList $marvelCharacters)
    {
        $this->marvelCharacters = $marvelCharacters;
    }

    public function index()
    {        
        if (Cache::has('marvel_characters')) {
            $response = Cache::get('marvel_characters');

            $data1 = $response['data'];

            $data = $data1['results'];

            $characters = $this->paginate($data);
        } 

        if (!Cache::has('marvel_characters')){
            $response = $this->marvelCharacters->execute($endpoint = 'characters');
            $data1 = $response['data'];

            $data = $data1['results'];

            $characters = $this->paginate($data);
        }
        return view('actors.list', compact('characters'));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function paginate($items, $perPage = 12, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
