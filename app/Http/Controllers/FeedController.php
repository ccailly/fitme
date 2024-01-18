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
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedController extends Controller
{
    public function index(Request $request): View | \Illuminate\Http\RedirectResponse
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $feed_posts = $this->getFeed($request);

        return view('feed', [
            'feed_posts' => $feed_posts,
        ]);

    }

    private function getFeed(Request $request): array
    {
        $communities_ids = CommunityMembers::where('user_id', $request->user()->id)->get('community_id');

        $posts = Post::whereIn('community_id', $communities_ids)->get();

        $feed = [];

        foreach ($posts as $post) {
            $feed_post = new \stdClass();
            $feed_post->id = $post->id;
            $feed_post->content = $post->content;
            $feed_post->community_id = $post->community_id;
            $feed_post->user_id = $post->user_id;
            $feed_post->date = $post->created_at;
            $feed_post->is_event = $post->is_event;
            $feed_post->likes = PostLikes::where('post_id', $post->id)->count();
            $feed_post->comments = [];

            foreach (PostComments::where('post_id', $post->id)->get() as $comment) {
                $comment_obj = new \stdClass();
                $comment_obj->content = $comment->content;
                $comment_obj->user_id = $comment->user_id;
                array_push($feed_post->comments, $comment_obj);
            }

            if ($post->is_event) {
                $event = Event::where('id', EventPosts::where('post_id', $post->id)->first()->event_id)->first();
                $event_obj = new \stdClass();
                $event_obj->id = $event->id;
                $event_obj->name = $event->name;
                $event_obj->description = $event->description;
                $event_obj->date = $event->date;
                $event_obj->location = $event->location;
                $event_obj->participants = EventParticipants::where('event_id', $event->id)->count();
                $feed_post->event = $event_obj;
            }

            array_push($feed, $feed_post);
        }

        return $feed;
    }
}
