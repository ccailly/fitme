<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedController extends Controller
{
    public function index(Request $request): View | \Illuminate\Http\RedirectResponse
    {
        // Check if the user is logged in
        if (!$request->user()) {
            return redirect()->route('login');
        }
        return view('feed');
    }
}
