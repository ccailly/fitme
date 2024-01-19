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
use App\Models\Sport;
use App\Models\User;
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
                $feed_post->event = $event_obj;
            }

            array_push($feed, $feed_post);
        }

        return $feed;
    }
}
