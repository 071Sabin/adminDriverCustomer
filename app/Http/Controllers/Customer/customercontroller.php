<?php

namespace App\Http\Controllers\Customer;

use App\broadcast;
use App\Customer;
use App\wallets;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class customercontroller extends Controller
{
    public function customersignup()
    {
        return view('customer.customersignup');
    }
    public function customersignupprocess(request $request)
    {
        // do {
        //     $custId = Str::random(6);
        // } while (Customer::where('custId', $custId)->exists());

        // $unique = Uuid::uuid4()->toString();
        $time = now()->timestamp;
        $random = mt_rand(100000, 999999);
        $combinedString = $random . $time;
        $unique = 'c-' . Str::limit(md5($combinedString), 6, '');

        $request->validate(
            [
                "fullname" => "required",
                "email" => "required|email|unique:customer,email",
                "phone" => "required|digits:10",
                "password" => "required|min:6",
                "custId" => "unique:custId",
            ],
            [
                "email.unique" => "This email is already in use!",
                "password" => "Password is too short!",
            ]
        );

        $u = new Customer();
        $u->custId = $unique;
        // $u->approved_status = 0;
        // $u->verification_status = 0;
        $u->name = $request->input('fullname');
        $u->email = $request->input('email');
        $u->phone = $request->input('phone');
        $u->password = bcrypt($request->input('password'));

        $u->save();

        $request->session()->flash('customer_register_success', true);
        // $emails = user1::pluck('email');
        // dd($emails);
        return redirect()->route('customerlogin');

    }
    public function customerlogin()
    {
        return view('customer.customerlogin');
    }

    public function customerloginprocess(request $request)
    {
        $credentials = $request->only('email', 'password');
        // dd(Auth::guard());
        if (Auth::guard('customer')->attempt($credentials)) {
            // Authentication passed...
            // echo "authenticated";
            $approved_status = Auth::guard('customer')->user()->approved_status;
            if ($approved_status == 1) {
                return redirect()->route('customerdashboard');
            } else {

                // returns to customer/customerlogin.blade.php
                return back()->withErrors("This account is currently under admin review !");
            }
        } else {
            // returns to customer/customerlogin.blade.php
            return back()->withErrors("Invalid email/password !!");
        }
    }



    public function customerdashboard()
    {
        // sending current authenticated customer balance to customerwelcome.blade.php but now we used eloquent relationships in customer.php(model) then it is resolved.
        // $w = new wallets();
        // $custBalance = $w->where('user_id', '=', Auth::guard('customer')->user()->custId)->value('balance');
        // return view('customer.customerdashboard', compact('custBalance'));


        // accessing the admin broadcast and showing to customers.
        $customerbroadcastMesg = broadcast::where('for', 'customer')->get();
        // dump($customerbroadcastMesg);
        //now we can access the current authenticated user balance using eloquent relationships.
        return view('customer.customerdashboard', compact('customerbroadcastMesg'));
    }

    public function customerlogout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('customerlogin');
    }
}