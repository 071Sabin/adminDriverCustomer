<?php

namespace App\Http\Controllers\Admin;

use App\admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class admincontroller extends Controller
{
    public function adminsignup()
    {
        return view('admin.adminsignup');
    }
    public function adminsignupprocess(request $request)
    {

        $request->validate(
            [
                "fullname" => "required",
                "email" => "required|email|unique:admin,email",
                "password" => "required|min:6",
            ],
            [
                "email.unique" => "This email is already in use!",
                "password" => "Password is too short!",
            ]
        );

        $u = new admin();
        // $u->custId = IdGenerator::generate(['table' => 'admin', 'length' => 6, 'prefix' => '#a-']);
        $u->name = $request->input('fullname');
        $u->email = $request->input('email');
        $u->password = bcrypt($request->input('password'));

        $u->save();

        $request->session()->flash('admin_register_success', true);
        return redirect()->route('adminlogin');
    }
    public function adminlogin()
    {
        return view('admin.adminlogin');
    }

    public function adminloginprocess(request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            // Authentication passed...
            return redirect()->route('admindashboard');
        } else {
            // return to admin login page ie views/admin/adminlogin.blade.php 
            return back()->withErrors("Invalid email/password !!");
        }
    }

    public function admindashboard()
    {
        $allbroadcasts = DB::table('broadcast')->get();
        return view('admin.admindashboard', compact('allbroadcasts'));
    }
    public function adminprofile()
    {
        return view('admin.adminprofile');
    }

    public function customeraccounts()
    {
        $customers = DB::table('customer')
            ->where('approved_status', '=', 1)
            ->get();
        $totalcust = count($customers);
        return view('admin.customeraccounts', compact('customers', 'totalcust'));
    }

    // this function shows the existing driver accounts who are approved ie approved_status = 1
    public function driveraccounts()
    {
        $drivers = DB::table('driver')
            ->where('approved_status', '=', 1)
            ->get();
        $totaldriver = count($drivers);
        return view('admin.driveraccounts', compact('drivers', 'totaldriver'));
    }
    public function adminlogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('adminlogin');
    }
}