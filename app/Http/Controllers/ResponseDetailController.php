<?php

namespace App\Http\Controllers;

use App\Response;
use FFI\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResponseDetailController extends Controller
{
    //
    public function getResponseDetailByResponseID(Request $request)
    {
        try{
            $responseid = $request->input('responseid');
            $response = Response::findOrFail($responseid);
            
            $responseDetailList = DB::table('response_details')->where('responseid', $responseid)->get();
            $result = array(
                "id" => "$response->id",
                "nameuser" => "$response->nameuser",
                "comment" => "$response->comment",
                "response_detail_list" => []
            );
            $responseDetailListArray = array();
            foreach($responseDetailList as $responseDetail)
            {
                $responseDetailArray = array(
                    "response_detail_id" => "$responseDetail->id",
                    "response_id" => "$responseDetail->responseid",
                    "response_optionid" => "$responseDetail->optionid",
                    "response_answer" => "$responseDetail->answer",
                );
                array_push($responseDetailListArray, $responseDetailArray);
            }
            array_push($result['response_detail_list'], $responseDetailListArray);
            return $result;
        }
        catch(Exception $e)
        {
            return $e;
        }

        
    }
    public function getResponseIDByEventID(Request $request)
    {
        $eventid = $request->input('eventid');
        $responseList = DB::table('responses')->where('eventid', $eventid)->get();
        return $responseList;
    }
}
