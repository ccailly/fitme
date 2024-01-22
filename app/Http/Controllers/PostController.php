<?php

namespace App\Http\Controllers;

use App\Models\PostLikes;
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
}
