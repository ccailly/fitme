<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Sport;
use App\Models\UserSports;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $sports = Sport::all();
        $user_sports = UserSports::where('user_id', $request->user()->id)->get('sport_id');
        $selected_sports = Sport::whereIn('id', $user_sports);

        return view('profile.edit', [
            'sports' => $sports,
            'selected_sports' => $selected_sports,
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        $request->validate([
            'avatar' => 'sometimes|image|mimes:jpeg,png,jpg,svg|max:2048|nullable',
            'sports' => 'regex:/^[\d,]+$/|nullable',
        ]);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarName = $request->user()->id.'.'.$request->avatar->extension();

            // Public Folder
            $request->avatar->move(public_path('avatars'), $avatarName);
            $avatarPath = '/avatars/' . $avatarName;
        }

        if ($avatarPath !== null) {
            $request->user()->avatar = $avatarPath;
        }

        if ($request->has('sports')) {
            UserSports::where('user_id', $request->user()->id)->delete();

            $sports_ids = explode(',', trim($request->sports));
            foreach ($sports_ids as $sport_id) {
                if (trim($sport_id) !== '') {
                    UserSports::create([
                        'user_id' => $request->user()->id,
                        'sport_id' => $sport_id
                    ]);
                }
            }
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
