<?php

namespace App\Http\Controllers;

use App\Response;
use App\ResponseDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResponseController extends Controller
{
    //
    public function index(Request $request)
    {
        $eventid = $request->input('eventid');
        $responselist = DB::table('responses')->where('eventid', $eventid)->get();
        return $responselist;
    }
    public function store(Request $request)
    {
        $request->validate([
            'nameuser' => 'required',
            'eventid' => 'required',
            'comment' => 'required',
            'responsedetail' => 'required'
        ]);
        $nameuser = $request->get('nameuser');
        $eventid = $request->get('eventid');
        $comment = $request->get('comment');
        $eventarray = array(
            "nameuser" => "$nameuser",  
            "eventid" => "$eventid",
            "comment" => "$comment"
        );
        $responses = Response::create($eventarray);

        $responsedetail = $request->get('responsedetail');
        foreach ($responsedetail as $answerforoption) {
            $responseid = $responses->id;
            $optionid = $answerforoption['optionid'];
            $answer = $answerforoption['answer'];
            $responsedetailarray = array(
                "responseid" => "$responseid",
                "optionid" => "$optionid",
                "answer" => "$answer"
            );
            ResponseDetail::create($responsedetailarray);
        }

        return $responses;
    }
    public function destroy(Response $response)
    {
        $response->delete();
        return response()->json();
    }
    public function update(Request $request) 
    {
        $request->validate([
            'responseid' => 'required',
            'nameuser' => 'required',
            'eventid' => 'required',
            'comment' => 'required',
            'responsedetail' => 'required'
        ]);
        $responseid = $request->get('responseid');
        $nameuser = $request->get('nameuser');
        $eventid = $request->get('eventid');
        $comment = $request->get('comment');
        $eventarray = array(
            "nameuser" => "$nameuser",  
            "eventid" => "$eventid",
            "comment" => "$comment"
        );
        $responses = Response::find($responseid);
        Response::update($eventarray);
        $responsedetail = $request->get('responsedetail');
        foreach ($responsedetail as $answerforoption) {
            $responsedetailid = $answerforoption['responsedetailid'];
            $optionid = $answerforoption['optionid'];
            $answer = $answerforoption['answer'];
            $responsedetailarray = array(
                "optionid" => "$optionid",
                "answer" => "$answer"
            );
            ResponseDetail::find($responsedetailid);
            ResponseDetail::update($responsedetailarray);
        }

        return $request;
    }
    public function show(Response $response)
    {
        return $response;
    }
}
