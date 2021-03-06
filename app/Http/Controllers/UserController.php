<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
     public function profile()
    {
        $user = Auth::user();
        return view('edit-profile',compact('user',$user));
    }

    public function CurrentProfile(){
        $user=Auth::user();
           return view('profile',compact('user',$user));
    }

    public function update_avatar(Request $request){

//dd($request);
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:400',
            'expertice' =>'required',
            'availability'=>'required',
            'area'=>'required',
            'location'=>'required',
            'contacts'=>'required|numeric',
        ]);

        $user = Auth::user();

        $location = explode(",", $request->location); 

        $avatarName = $user->id.'_avatar'.time().'.'.request()->avatar->getClientOriginalExtension();
        $request->avatar->storeAs('avatars',$avatarName);
        $user->avatar = $avatarName;
        $user->expertice=$request->expertice;
        $user->icon = strtolower(str_replace(' ', '', $user->expertice));
        $user->availability=$request->availability;
        $user->area=$request->area;
        $user->lat=$location[0];
        $user->lng=$location[1];
        $user->contacts=$request->contacts;
        $user->save();

        return back()
            ->with('success','Profile  Updated.');

    }
}
