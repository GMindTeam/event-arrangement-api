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
    public function getResponseListFromEventID($id)
    {
        $eventid = $id;
        $responseList = DB::table('responses')->where('eventid', $eventid)->get();
        return $responseList;
    }
    public function createResponse(Request $request)
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
        $responseArray = array(
            "nameuser" => "$nameuser",
            "eventid" => "$eventid",
            "comment" => "$comment"
        );
        $responses = Response::create($responseArray);

        $responseDetailList = $request->get('responsedetail');
        foreach ($responseDetailList as $responseDetail) {
            $responseid = $responses->id;
            $optionid = $responseDetail['optionid'];
            $answer = $responseDetail['answer'];
            $responseDetailArray = array(
                "responseid" => "$responseid",
                "optionid" => "$optionid",
                "answer" => "$answer"
            );
            ResponseDetail::create($responseDetailArray);
        }

        return $responses;
    }
    public function deleteResponse($id)
    {
        try {
            $response = Response::findOrFail($id);
            $response->delete();
            $listResponseDetailID = DB::select('select id from response_details where responseid = ?', [$id]);
            foreach ($listResponseDetailID as $responseDetailID) {
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
    public function editResponse(Request $request, $id)
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
        $responseArray = array(
            "nameuser" => "$nameuser",
            "eventid" => "$eventid",
            "comment" => "$comment"
        );
        try{
            $responses = Response::findOrFail($responseid);
            $responses->update($responseArray);
            $responseDetailList = $request->get('responsedetail');
            $responseDetailIDList = DB::select('select id,optionid from response_details where responseid = ?', [$responseid]);
            foreach ($responseDetailList as $responseDetail) {
                $optionid = $responseDetail['optionid'];
                $answer = $responseDetail['answer'];
                $respondetailID = 0;
                foreach ($responseDetailIDList as $responseDetailID) {
                    if ($responseDetailID->optionid == $optionid)
                        $respondetailID = $responseDetailID->id;
                }
                $responseDetailArray = array(
                    "optionid" => "$optionid",
                    "answer" => "$answer"
                );
                $responseDetail = ResponseDetail::find($respondetailID);
                $responseDetail->update($responseDetailArray);
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
}
