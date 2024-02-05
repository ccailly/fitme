<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityMembers;
use App\Models\Event;
use App\Models\EventParticipants;
use App\Models\EventPosts;
use App\Models\Post;
use App\Models\PostComments;
use App\Models\PostLikes;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedController extends Controller
{
    public function index(Request $request): View | RedirectResponse
    {
        $feed_posts = $this->getFeed($request);

        $communities = $request->user()->communities()->get();
        $events = array();
        foreach ($communities as $community) {
            $events[$community->id] = $community->events()->get();
        }

        return view('feed', [
            'title' => 'Mon Feed',
            'feed_posts' => $feed_posts,
            'communities' => $communities,
            'events' => $events,
        ]);
    }

    private function getFeed(Request $request): array
    {
        $communities_ids = CommunityMembers::where('user_id', $request->user()->id)->get('community_id');

        $posts = Post::whereIn('community_id', $communities_ids)->orderBy('created_at', 'desc')->get();

        $feed = [];

        foreach ($posts as $post) {
            $feed_post = new \stdClass();
            $feed_post->id = $post->id;
            $feed_post->content = $post->content;
            $feed_post->community = Community::find($post->community_id);
            $feed_post->user = User::find($post->user_id);
            $feed_post->date = $post->created_at;
            $feed_post->likes = PostLikes::where('post_id', $post->id)->count();
            $feed_post->liked = PostLikes::where('post_id', $post->id)->where('user_id', $request->user()->id)->exists();
            $feed_post->comments = [];

            foreach (PostComments::where('post_id', $post->id)->get() as $comment) {
                $comment_obj = new \stdClass();
                $comment_obj->content = $comment->comment;
                $comment_obj->user = User::find($comment->user_id);
                array_push($feed_post->comments, $comment_obj);
            }

            $eventPost = EventPosts::where('post_id', $post->id)->first();
            if ($eventPost) {
                $event = Event::where('id', $eventPost->event_id)->first();
                $event_obj = new \stdClass();
                $event_obj->id = $event->id;
                $event_obj->name = $event->name;
                $event_obj->description = $event->description;
                $event_obj->date = \Carbon\Carbon::createFromTimestamp(strtotime($event->date_time));
                $event_obj->location = $event->location;
                $event_obj->participants = EventParticipants::where('event_id', $event->id)->get()->count();
                $event_obj->participate = EventParticipants::where('event_id', $event->id)->where('user_id', $request->user()->id)->exists();
                $feed_post->event = $event_obj;
            }

            array_push($feed, $feed_post);
        }

        return $feed;
    }

    public function addPost(Request $request): RedirectResponse
    {
        $request->validate([
            'community_id' => 'required|integer|exists:communities,id',
            'content' => 'required|string|max:255',
            'is_event' => 'sometimes',
            'event_id' => 'required_if:is_event,on|integer|min:0',
            'event_name' => 'required_if:event_id,0|nullable|string|max:30',
            'event_description' => 'required_if:event_id,0|nullable|string|max:255',
            'event_date_time' => 'required_if:event_id,0|nullable|date',
            'event_location' => 'required_if:event_id,0|nullable|string|max:255',
            'event_max_participants' => 'required_if:event_id,0|nullable|integer|min:1',
        ]);

        $post = Post::create([
            'user_id' => $request->user()->id,
            'community_id' => $request->input('community_id'),
            'content' => $request->input('content'),
            'is_event' => (bool) $request->input('is_event', false),
        ]);

        if ($request->input('is_event', false)) {
            if ($request->input('event_id') > 0) {
                $event = Event::find($request->input('event_id'));
            } else {
                $event = Event::create([
                    'name' => $request->input('event_name'),
                    'description' => $request->input('event_description'),
                    'user_id' => $request->user()->id,
                    'community_id' => $request->input('community_id'),
                    'date_time' => $request->input('event_date_time'),
                    'location' => $request->input('event_location'),
                    'max_participants' => $request->input('event_max_participants'),
                ]);
            }

            EventPosts::create([
                'event_id' => $event->id,
                'post_id' => $post->id,
            ]);
        }

        return redirect()->route('feed')->with('success', 'Votre post a bien été publié !');
    }
}
