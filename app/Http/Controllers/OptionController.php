<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OptionController extends Controller
{
    //
    public function getOptionByEventID(Request $request)
    {
        $eventid = $request->input('eventid');
        $optionlist = DB::table('options')->where('eventid', $eventid)->get();
        return $optionlist;
    }
}
