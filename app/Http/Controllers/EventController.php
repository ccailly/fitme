<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventParticipants;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function toggleParticipate(Request $request)
    {
        $request->validate([
            'csrf_token' => 'required|in:' . csrf_token(),
            'event_id' => 'required|integer',
            'participated' => 'required|boolean',
        ]);

        if ($request->participated) {
            EventParticipants::where('event_id', $request->event_id)->where('user_id', $request->user()->id)->delete();
        } else {
            $event = Event::find($request->event_id);
            $currentParticipants = EventParticipants::where('event_id', $request->event_id)->count();

            if ($currentParticipants < $event->max_participants) {
                EventParticipants::create([
                    'event_id' => $request->event_id,
                    'user_id' => $request->user()->id,
                ]);
            } else {
                return response()->json([
                    'error' => 'Le nombre maximum de participants a été atteint.'
                ], 400);
            }
        }

        return response()->json([
            'participated' => !$request->participated,
            'participants' => EventParticipants::where('event_id', $request->event_id)->count()
        ]);
    }
}
