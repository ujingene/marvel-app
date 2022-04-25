<?php

namespace App\Http\Controllers;

use App\Actions\MarvelList;

class CharacterController extends Controller
{
    public function __construct(MarvelList $marvelCharacters)
    {
        $this->marvelCharacters = $marvelCharacters;
    }

    public function index()
    {        
        $characters = $this->marvelCharacters->execute($endpoint = 'characters');

        return view('actors.list', compact('characters'));
    }
}
