<?php

namespace App\Http\Controllers;

class CharacterController extends Controller
{
    public function index()
    {
        $characters = [];
        return view('actors.list', compact('characters'));
    }
}
