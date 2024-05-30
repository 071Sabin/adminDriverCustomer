<?php

namespace App\Http\Controllers\Driver;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class driverprofilecontroller extends Controller
{
    public function driverprofile()
    {
        $currentDriverDetails = Auth::guard('driver')->user();
        return view('driver.driverprofile', compact('currentDriverDetails'));
    }

    public function UpdateDriverDetails(request $request)
    {
        $request->validate(
            [
                'username' => 'required',
                'phone' => 'digits:10',
            ],
            [
                'username.required' => 'Enter your new username first!',
                'phone.required' => "Enter your phone number.",
            ]
        );

        $currentDriver = Auth::guard('driver')->user();
        $currentDriver->name = $request->username;
        $currentDriver->phone = $request->phone;
        $currentDriver->save();

        // returns to customerprofile.blade.php when user updates their username
        return back()->with('driverDetailsUpdated', true);
    }


    public function upload_driver_profile_pic(request $request)
    {
        $request->validate(
            [
                'driver_profile_pic' => 'required|mimes:png,jpg,jpeg',
            ],
            [
                'driver_profile_pic.required' => 'Please choose the profile picture first.',
            ]
        );

        $d = Auth::guard('driver')->user();
        $profilepic = $request->file('driver_profile_pic')->store('driver_profile_picture');
        
        $d->profile_pic = $profilepic;
        $d->save();

        // returns to customerprofile.blade.php
        return back()->with('driver_profile_pic_uploaded', true);
    }

    public function delete_driver_profile_pic(request $request)
    {
        $currentDriver = Auth::guard('driver')->user();

        $profile_pic = $currentDriver->profile_pic;
        Storage::delete($profile_pic);
        $currentDriver->profile_pic = null;

        $currentDriver->save();
        return back()->with('driver_profile_pic_deleted', true);

    }
}