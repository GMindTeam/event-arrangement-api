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
        $optionlist = DB::table('response_details')->where('responseid', $responseid)->get();
        return $optionlist;
    }
}
