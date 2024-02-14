<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityMembers;
use App\Models\CommunitySports;
use App\Models\Event;
use App\Models\EventParticipants;
use App\Models\EventPosts;
use App\Models\Post;
use App\Models\Sport;
use App\Models\User;
use App\Models\UserSports;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommunityController extends Controller
{

    public function index(Request $request): View
    {
        $user_sports_ids = UserSports::where('user_id', $request->user()->id)->pluck('sport_id');

        $user_communities_ids = CommunityMembers::where('user_id', $request->user()->id)->pluck('community_id');

        $communities_sports = CommunitySports::whereIn('sport_id', $user_sports_ids)->pluck('community_id');

        $communities = Community::whereIn('id', $communities_sports)->whereNotIn('id', $user_communities_ids);

        $other_communities = Community::whereNotIn('id', $communities_sports)->whereNotIn('id', $user_communities_ids);

        $communities = $communities->union($other_communities)->get();

        foreach ($communities as $community) {
            $community->members = CommunityMembers::where('community_id', $community->id)->get()->count();
            $community->following = CommunityMembers::where('community_id', $community->id)->where('user_id', $request->user()->id)->exists();
            $community->sports = Sport::whereIn('id', CommunitySports::where('community_id', $community->id)->get('sport_id'))->get();
        }

        return view('communities', [
            'communities' => $communities,
        ]);
    }

    public function show(Request $request, $community_id): View
    {
        $community = Community::findOrFail($community_id);
        $members_ids = CommunityMembers::where('community_id', $community_id)->get('user_id');
        $members = User::whereIn('id', $members_ids)->take(6)->get();
        $post_ids = Post::where('community_id', $community_id)->get('id');
        $events = Event::whereIn('id', EventPosts::whereIn('post_id', $post_ids)->get('event_id'))->orderBy('date_time', 'asc')->get();
        $following = CommunityMembers::where('user_id', $request->user()->id)->where('community_id', $community_id)->exists();

        foreach ($events as $event) {
            $event->owner = User::findOrFail($event->user_id);
            $event->date_time = \Carbon\Carbon::createFromTimestamp(strtotime($event->date_time));
            $event->participants = EventParticipants::where('event_id', $event->id)->get()->count();
            $event->participate = EventParticipants::where('event_id', $event->id)->where('user_id', $request->user()->id)->exists();
        }

        $members->nb = count($members_ids);

        return view('community', [
            'community' => $community,
            'members' => $members,
            'events' => $events,
            'following' => $following,
        ]);
    }

    public function getAllMembers($community_id): JsonResponse
    {
        $members_ids = CommunityMembers::where('community_id', $community_id)->get('user_id');
        $members = User::whereIn('id', $members_ids)->get();

        return response()->json($members);
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
