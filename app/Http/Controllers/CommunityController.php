<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityMembers;
use App\Models\Event;
use App\Models\EventParticipants;
use App\Models\EventPosts;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function show(Request $request, $community_id): View
    {
        $community = Community::findOrFail($community_id);
        $members_ids = CommunityMembers::where('community_id', $community_id)->get('user_id');
        $members = User::whereIn('id', $members_ids)->get();
        $post_ids = Post::where('community_id', $community_id)->get('id');
        $events = Event::whereIn('id', EventPosts::whereIn('post_id', $post_ids)->get('event_id'))->orderBy('date_time', 'asc')->get();
        $following = CommunityMembers::where('user_id', $request->user()->id)->where('community_id', $community_id)->exists();

        foreach ($events as $event) {
            $event->owner = User::findOrFail($event->user_id);
            $event->date_time = \Carbon\Carbon::createFromTimestamp(strtotime($event->date_time));
            $event->participants = EventParticipants::where('event_id', $event->id)->get()->count();
            $event->participate = EventParticipants::where('event_id', $event->id)->where('user_id', $request->user()->id)->exists();
        }
        return view('community', [
            'community' => $community,
            'members' => $members,
            'events' => $events,
            'following' => $following,
        ]);
    }

    public function toggleFollow(Request $request): JsonResponse
    {
        $request->validate([
            'csrf_token' => 'required|in:' . csrf_token(),
            'community_id' => 'required|integer',
            'following' => 'required|boolean',
        ]);

        if ($request->following) {
            CommunityMembers::where('community_id', $request->community_id)->where('user_id', $request->user()->id)->delete();
        } else {
            CommunityMembers::create([
                'community_id' => $request->community_id,
                'user_id' => $request->user()->id,
            ]);
        }

        return response()->json([
            'following' => !$request->following,
            'members' => CommunityMembers::where('community_id', $request->community_id)->get()->count(),
        ]);
    }
}
