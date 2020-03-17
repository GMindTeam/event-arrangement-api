<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResponseDetailController extends Controller
{
    //
    public function getResponseDetailByResponseID(Request $request)
    {
        $responseid = $request->input('responseid');
        $responseDetailList = DB::table('response_details')->where('responseid', $responseid)->get();
        return $responseDetailList;
    }
    public function getResponseIDByEventID(Request $request)
    {
        $eventid = $request->input('eventid');
        $responseList = DB::table('responses')->where('eventid', $eventid)->get();
        return $responseList;
    }
}
