<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityMembers;
use App\Models\Sport;
use App\Models\User;
use App\Models\UserSports;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($user_id)
    {
        $user = User::findOrFail($user_id);
        $communities_ids = CommunityMembers::where('user_id', $user_id)->get('community_id');
        $communities = Community::whereIn('id', $communities_ids)->get();
        $sports_ids = UserSports::where('user_id', $user_id)->get('sport_id');
        $sports = Sport::whereIn('id', $sports_ids)->get();

        return view('user', [
            'user' => $user,
            'communities' => $communities,
            'sports' => $sports
        ]);
    }
}
