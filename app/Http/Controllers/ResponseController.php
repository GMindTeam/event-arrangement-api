<?php

namespace App\Http\Controllers;

use App\Response;
use App\ResponseDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception as GlobalException;

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
    public function destroy($id)
    {
        try {
            $response = Response::findOrFail($id);
            $response->delete();
            $listIDResponseDetail = DB::select('select id from response_details where responseid = ?', [$id]);
            foreach ($listIDResponseDetail as $responseDetailID) {
                $responseDetail = ResponseDetail::find($responseDetailID->id);
                $responseDetail->delete();
            }
            return [
                'message' => 'Delete completed',
            ];;
        } catch (GlobalException $e) {
            return [
                'message' => 'ResponseID not found',
            ];;
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nameuser' => 'required',
            'eventid' => 'required',
            'comment' => 'required',
            'responsedetail' => 'required'
        ]);
        $responseid = $id;
        $nameuser = $request->get('nameuser');
        $eventid = $request->get('eventid');
        $comment = $request->get('comment');
        $eventarray = array(
            "nameuser" => "$nameuser",
            "eventid" => "$eventid",
            "comment" => "$comment"
        );
        try{
            $responses = Response::findOrFail($responseid);
            $responses->update($eventarray);
            $responsedetail = $request->get('responsedetail');
            $responseDetailIDList = DB::select('select id,optionid from response_details where responseid = ?', [$responseid]);
            foreach ($responsedetail as $answerforoption) {
                $optionid = $answerforoption['optionid'];
                $answer = $answerforoption['answer'];
                $respondetailID = 1;
                foreach ($responseDetailIDList as $responseDetailID) {
                    if ($responseDetailID->optionid == $optionid)
                        $respondetailID = $responseDetailID->id;
                }
    
                $responsedetailarray = array(
                    "optionid" => "$optionid",
                    "answer" => "$answer"
                );
                $responseDetail = ResponseDetail::find($respondetailID);
                $responseDetail->update($responsedetailarray);
            }
    
             return [
                'message' => 'Update successful',
            ];;
        } catch (GlobalException $e) {
            return [
                'message' => 'ResponseID not found',
            ];;
        }
        
    }
    public function show(Response $response)
    {
        return $response;
    }
}
