<?php

namespace App\Http\Controllers\Driver;

use App\Driver;
use App\broadcast;
use Ramsey\Uuid\Uuid;
use App\driverapproval;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class drivercontroller extends Controller
{
    public function driversignup()
    {
        return view('driver.driversignup');
    }
    public function driversignupprocess(request $request)
    {

        // $driverId = Uuid::uuid4()->toString();
        $time = now()->timestamp;
        $random = mt_rand(100000, 999999);
        $combinedString = $random . $time;
        $driverId = 'd-' . Str::limit(md5($combinedString), 6, '');

        $request->validate(
            [
                "fullname" => "required",
                "email" => "required|email|unique:driver,email",
                "phone" => "required|digits:10",
                "password" => "required|min:6",
                "driverId" => "unique:driverId",

            ],
            [
                "email.unique" => "This email is already in use!",
                "password" => "Password is too short!",
            ]
        );

        $u = new Driver();
        $u->driverId = $driverId;
        $u->approved_status = 0;
        $u->name = $request->input('fullname');
        $u->email = $request->input('email');
        $u->phone = $request->input('phone');
        $u->password = bcrypt($request->input('password'));

        $u->save();

        $request->session()->flash('driver_register_success', true);
        // $emails = user1::pluck('email');
        // dd($emails);
        return redirect()->route('driverlogin');

    }
    public function driverlogin()
    {
        return view('driver.driverlogin');
    }

    public function driverloginprocess(request $request)
    {
        $credentials = $request->only('email', 'password');
        // dd(Auth::guard());
        if (Auth::guard('driver')->attempt($credentials)) {
            // Authentication passed...
            // echo "authenticated";
            $approved_status = Auth::guard('driver')->user()->approved_status;
            if ($approved_status == 1) {
                return redirect()->route('driverdashboard');
            } else {
                // returns to driver/driverlogin.blade.php
                return back()->withErrors(("This account is currently under admin review !"));
            }

        } else {
            // returns to driver/driverlogin.blade.php
            return back()->withErrors("Invalid email/password !!");
        }
    }


    public function driverdashboard()
    {
        $driverbroadcastMesg = broadcast::where('for', 'driver')->get();
        return view('driver.driverdashboard', compact('driverbroadcastMesg'));

    }
    public function driverlogout()
    {
        Auth::guard('driver')->logout();
        return redirect()->route('driverlogin');
    }
}