<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function createFollow(User $user) {
        $loggedUserId = auth()->user()->id;
        //you cannot follow yourself
            if($loggedUserId == $user->id) {
                return back()->with('failure','You cannot follow yourself');
            }
        //you cannot follow someone you already follow
        $existingFollow = Follow::where('user_id',$loggedUserId)->where('followeduser',$user->id)->count();
        if($existingFollow > 0) {
            return back()->with('failure','You already follow this user');
        }

        Follow::create([
            'user_id' => $loggedUserId,
            'followeduser' => $user->id,
        ]);

        return back()->with('success','You are now following ' . $user->username);

    }

    public function removeFollow(User $user) {
        Follow::where('user_id',auth()->user()->id)->where('followeduser',$user->id)->delete();
        return back()->with('success','You have unfollowed ' . $user->username);
    }
}
