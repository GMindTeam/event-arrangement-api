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
    public function store(Request $request)
    {
       
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'options' => 'required',
        ]);

        $name = $request->get('name');
        $description = $request->get('description');
        $eventarray = array(
            "name" => "$name",  
            "description" => "$description"
        );
        $event = Event::create($eventarray);
        $eventid = $event->id;
        $listoption = $request->get('options');
        foreach ($listoption as $option) {
            $content = $option['content'];
            $timearray = array(
                "eventid" => "$eventid",
                "content" => "$content"
            );
            Option::create($timearray);
        }
        return $event;
    }
    public function destroy($id)
    {
        try{
            $event = Event::findOrFail($id);
            $event->delete();
            return [
                'message' => 'Delete successful',
            ];;
        }
        
        catch (GlobalException $e) {
            return [
                'message' => 'EventID not found',
            ];;
        }
        
    }
    public function update(Request $request,$id) 
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'options' => 'required',
        ]);

        $name = $request->get('name');
        $description = $request->get('description');
        $eventarray = array(
            "name" => "$name",  
            "description" => "$description"
        );
        try{
            $event = Event::findOrFail($id);
            $event->update($eventarray);
            $listoption = $request->get('options');
            $optionListID = DB::select('select id,content from options where eventid = ?',[$id]);
            for ($i = 0; $i < sizeof($listoption); $i++) {
                $content = $listoption[$i]['content'];
                $optionid = $optionListID[$i]->id;
                
                $timearray = array(
                    "eventid" => "$id",
                    "content" => "$content"
                );
                $option = Option::find($optionid);
                $option->update($timearray);
            }
    
            return [
                'message' => 'Update successful',
            ];;
        }
        catch (GlobalException $e) {
            return [
                'message' => 'EventID not found',
            ];;
        }
        
    }
    public function show($id)
    {
        try{
            $event = Event::findOrFail($id);
            return $event;
        }
        
        catch (GlobalException $e) {
            return [
                'message' => 'EventID not found',
            ];;
        }
        
    }
}
