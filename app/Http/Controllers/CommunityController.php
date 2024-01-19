<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Community;

class CommunityController extends Controller
{
    public function community(Community $community)
    {
        //dd($community);
        return view('community', [
            'community' => $community
        ]);
    }
}
