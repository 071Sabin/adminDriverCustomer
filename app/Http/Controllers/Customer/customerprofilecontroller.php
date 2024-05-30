<?php

namespace App\Http\Controllers\Customer;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class customerprofilecontroller extends Controller
{
    public function customerprofile()
    {
        $currentCustomerDetails = Auth::guard('customer')->user();
        return view('customer.customerprofile', compact('currentCustomerDetails'));
    }


    public function UpdateCustomerDetails(request $request)
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

        $currentCustomer = Auth::guard('customer')->user();
        $currentCustomer->name = $request->username;
        $currentCustomer->phone = $request->phone;
        $currentCustomer->save();

        // returns to customerprofile.blade.php when user updates their username
        return back()->with('customerDetailsUpdated', true);
    }

    public function upload_customer_profile_pic(request $request)
    {
        $request->validate(
            [
                'customer_profile_pic' => 'required|mimes:png,jpg,jpeg',
            ],
            [
                'customer_profile_pic.required' => 'Please choose the profile picture first.',
            ]
        );

        $c = Auth::guard('customer')->user();
        $profilepic = $request->file('customer_profile_pic')->store('customer_profile_picture');
        // dd($profilepic);
        $c->profile_pic = $profilepic;
        $c->save();

        // returns to customerprofile.blade.php
        return back()->with('customer_profile_pic_uploaded', true);
    }

    public function delete_customer_profile_pic(request $request)
    {
        $currentCustomer = Auth::guard('customer')->user();

        $profile_pic = $currentCustomer->profile_pic;
        Storage::delete($profile_pic);
        $currentCustomer->profile_pic = null;

        $currentCustomer->save();
        return back()->with('customer_profile_pic_deleted', true);

    }
}