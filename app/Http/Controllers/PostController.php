<?php

namespace App\Http\Controllers;

use App\Models\PostComments;
use App\Models\PostLikes;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function toggleLike(Request $request)
    {

        $request->validate([
            'csrf_token' => 'required|in:' . csrf_token(),
            'post_id' => 'required|integer',
            'liked' => 'required|boolean',
        ]);

        if ($request->liked) {
            PostLikes::where('post_id', $request->post_id)->where('user_id', $request->user()->id)->delete();
        } else {
            PostLikes::create([
                'post_id' => $request->post_id,
                'user_id' => $request->user()->id,
            ]);
        }

        return response()->json([
            'liked' => !$request->liked,
            'likes' => PostLikes::where('post_id', $request->post_id)->count()
        ]);
    }

    public function getComments(Request $request)
    {
        $request->validate([
            'post_id' => 'required|integer',
        ]);

        $comments = [];

        foreach (PostComments::where('post_id', $request->post_id)->orderBy('created_at', 'desc')->get() as $comment) {
            $comment_obj = new \stdClass();
            $comment_obj->content = $comment->comment;
            $comment_obj->user = User::find($comment->user_id);
            $comment_obj->posted_date = $comment->created_at->diffForHumans();
            array_push($comments, $comment_obj);
        }

        return response()->json([
            'comments' => $comments,
        ]);
    }

    public function addComment(Request $request)
    {
        $request->validate([
            'csrf_token' => 'required|in:' . csrf_token(),
            'post_id' => 'required|integer',
            'comment' => 'required|string|min:1|max:100',
        ]);

        $comment = PostComments::create([
            'post_id' => $request->post_id,
            'user_id' => $request->user()->id,
            'comment' => $request->comment,
        ]);

        if ($comment) {
            return response()->json([
                'comment' => array(
                    'content' => $comment->comment,
                    'user' => User::find($comment->user_id),
                    'posted_date' => $comment->created_at->diffForHumans(),
                ),
                'nb_comments' => PostComments::where('post_id', $request->post_id)->count()
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to add comment',
            ], 500);
        }
    }
}
