<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HabbitController extends Controller
{
    public function index()
    {
        return view('pages.habbits.index');
    }
}
