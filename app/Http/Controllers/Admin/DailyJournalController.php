<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyJournalReponse;
use Illuminate\Http\Request;

class DailyJournalController extends Controller
{
    public function index()
    {
        return view("users.daily-journal.index");
    }

    public function show(DailyJournalReponse $response)
    {
        return view("users.daily-journal.show", compact("response"));
    }

}
