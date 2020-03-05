<?php

namespace App\Http\Controllers;

use App\Event;
use App\Option;
use Illuminate\Http\Request;

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
        return $request->all();
    }
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json();
    }
    public function update(Event $event, Request $request) 
    {
        $event->update($request->all());
        return $event;
    }
    public function show(Event $event)
    {
        return $event;
    }
}
