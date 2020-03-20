<?php

namespace App\Http\Controllers;

use App\Event;
use App\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception as GlobalException;
use FFI\Exception;

class EventController extends Controller
{
    //
    public function createEvent(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'options' => 'required',
        ]);
        $name = $request->get('name');
        $description = $request->get('description');
        $eventArray = array(
            "name" => "$name",
            "description" => "$description"
        );
        $event = Event::create($eventArray);
        $eventid = $event->id;
        $listOption = $request->get('options');
        foreach ($listOption as $option) {
            $content = $option['content'];
            $optionArray = array(
                "eventid" => "$eventid",
                "content" => "$content"
            );
            Option::create($optionArray);
        }
        return $event;
    }

    public function updateEvent(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'options' => 'required',
        ]);
        $name = $request->get('name');
        $description = $request->get('description');
        $eventArray = array(
            "name" => "$name",
            "description" => "$description"
        );
        try {
            $event = Event::findOrFail($id);
            $event->update($eventArray);
            $listOption = $request->get('options');
            $optionListID = DB::select('select id,content from options where eventid = ?', [$id]);
            for ($i = 0; $i < sizeof($listOption); $i++) {
                $content = $listOption[$i]['content'];
                $optionid = $optionListID[$i]->id;
                $optionArray = array(
                    "eventid" => "$id",
                    "content" => "$content"
                );
                $option = Option::find($optionid);
                $option->update($optionArray);
            }
            return [
                'message' => 'Update successful',
            ];;
        } catch (GlobalException $e) {
            return [
                'message' => 'EventID not found',
            ];;
        }
    }
    public function getEventDetailFromEventID($id)
    {
        try {
            $event = Event::findOrFail($id);
            $eventid = $event->id;
            $responseList = DB::table('responses')->where('eventid', $eventid)->get();
            $result = array(
                "id" => "$event->id",
                "name" => "$event->name",
                "description" => "$event->description",
                "responselist" => []
            );
            $responseListArray = array();
            foreach ($responseList as $response) {
                $responseArray = array(
                    "response_id" => "$response->id",
                    "response_nameUser" => "$response->nameuser",
                    "response_comment" => "$response->comment",
                    "response_detail_list" => []
                );
                $responseid = $response->id;
                $responseDetailList = DB::table('response_details')->where('responseid', $responseid)->get();
                foreach ($responseDetailList as $response_detail) {
                    $responseDetailArray = array(
                        "response_detail_id" => "$response_detail->id",
                        "response_id" => "$response_detail->responseid",
                        "response_optionid" => "$response_detail->optionid",
                        "response_answer" => "$response_detail->answer",
                    );
                    array_push($responseArray["response_detail_list"], $responseDetailArray);
                }
                array_push($responseListArray, $responseArray);
            }
            array_push($result["responselist"], $responseListArray);
            return $result;
        } catch (GlobalException $e) {
            return $e;
        }
    }
        // public function destroy($id)
    // {
    //     try {
    //         $event = Event::findOrFail($id);
    //         $event->delete();
    //         return [
    //             'message' => 'Delete successful',
    //         ];;
    //     } catch (GlobalException $e) {
    //         return [
    //             'message' => 'EventID not found',
    //         ];;
    //     }
    // }
}
