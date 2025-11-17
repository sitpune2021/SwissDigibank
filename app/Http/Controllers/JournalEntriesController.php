<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JournalEntriesController extends Controller
{
     public function journal_index()
    {
        return view("journal-entry.index");
    }
   

}
