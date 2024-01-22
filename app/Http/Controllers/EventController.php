<?php

namespace App\Http\Controllers;

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
            EventParticipants::create([
                'event_id' => $request->event_id,
                'user_id' => $request->user()->id,
            ]);
        }

        return response()->json([
            'participated' => !$request->participated,
            'participants' => EventParticipants::where('event_id', $request->event_id)->count()
        ]);
    }
}
