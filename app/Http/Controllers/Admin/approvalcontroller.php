<?php

namespace App\Http\Controllers\Admin;

use App\wallets;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class approvalcontroller extends Controller
{
    // THIS FUNCTION SHOWS THE PENDING APPROVAL FOR CUSTOMER SIGNUPS, get method
    public function customerapproval()
    {
        if (Auth::guard('admin')->check()) {
            $pendingcustomers = DB::table('customer')
                ->where("approved_status", "=", 0)
                ->get();
            return view('admin.customerapproval', compact('pendingcustomers'));
        }
    }


    // THIS FUNCTION SHOWS THE PENDING APPROVAL FOR DRIVER SIGNUPS, get method in web.php
    public function driverapproval()
    {
        if (Auth::guard('admin')->check()) {
            $pendingdrivers = DB::table('driver')
                ->where("approved_status", "=", 0)
                ->get();
            return view('admin.driverapproval', compact('pendingdrivers'));
        }
    }


    // this function runs the approval process of both customer and driver, post method
    public function approvalprocess(request $request)
    {
        // using the action in the customer/driverapproval.blade file, as input field name property and it's value property will have either accept/reject will be stored in $action
        $action = $request->input('action');

        // usercategory is given in the hidden input in same above blade file, to get either the request from driver or customer page.
        $usercategory = $request->input('category');

        // these 2 will store the driverand customer id that is submitted by selecting the checkbox on the table above.
        // and then used below to iterate one by one.
        $selectedcustId = $request->input('customeritems', []);
        $selectedDriverId = $request->input('driveritems', []);

        // dd($custId);
        // updating the approved_status to 1 if the condition meets and in respective table according to the value taken from the above hidden input in customerapproval or driverapproval blade file
        if (count($selectedcustId) > 0 && $action === 'approve' && $usercategory === "customer") {
            // initial value of i = 0, to access the first value and increase by 1, put the custId in the wallets table, until the selected cuid value is completed using the for loop.
            $i = 0;
            // iterating using items from the blade file that takes the default id from the table and helps in iterating for each and for the same respective id the status is updating.
            foreach ($selectedcustId as $u) {
                DB::table('customer')
                    ->where('custId', $u)
                    ->update(['approved_status' => 1]);

                $time = now()->timestamp;
                $random = mt_rand(100000, 999999);
                $combinedString = $random . $time;
                $unique = 'w-' . Str::limit(md5($combinedString), 7, '');

                // updating the wallet table with each approved userid
                $w = new wallets();
                $w->wallet_id = $unique;
                $w->user_id = $u;
                $w->user_type = 'customer';
                $w->balance = 0.00;
                $w->created_at = now();
                $w->updated_at = now();
                $w->save();

                // increasing value of i by 1 each time the loop is completed to get all the users approved.
                $i += 1;
            }

            // /return to admin/customerapproval.blade.php and show the number of customer approved
            return redirect()->back()->with('approvalsuccess', $i . ' no. of customers approved.');

        } elseif (count($selectedcustId) > 0 && $action === 'reject' && $usercategory === "customer") {
            dd("these accounts are rejected", $selectedcustId);
        }

        // APPROVAL PROCESS FOR DRIVER AND ADDING THE DRIVER WALLET AFTER APPROVAL
        if (count($selectedDriverId) > 0 && $action === 'approve' && $usercategory === "driver") {
            // dd("these accounts are approved", $uid);
            $i = 0;
            foreach ($selectedDriverId as $u) {
                DB::table('driver')
                    ->where('driverId', $u)
                    ->update(['approved_status' => 1]);

                // SETTING THE RANDOM VALUE FOR WALLET ID
                $time = now()->timestamp;
                $random = mt_rand(100000, 999999);
                $combinedString = $random . $time;
                $unique = 'w-' . Str::limit(md5($combinedString), 7, '');

                // updating the wallet table with each approved userid
                $w = new wallets();
                // object->column_name= value
                $w->wallet_id = $unique;
                $w->user_id = $u;
                $w->user_type = 'driver';
                $w->balance = 0.00;
                $w->created_at = now();
                $w->updated_at = now();

                $w->save();

                // increasing value of i by 1 each time the loop is completed to get all the users approved.
                $i += 1;
            }

            // returns to admin/driverapproval.blade.php to show the drivers approved passing this session using with() fn.
            return redirect()->back()->with('approvalsuccess', $i . ' no. of drivers approved.');

        } elseif (count($selectedDriverId) > 0 && $action === 'reject' && $usercategory === "driver") {
            dd("these accounts are rejected", $selectedDriverId);


        } else {
            // this part works when neither of the conditions for customer&Driver satisfies.    
            // this else part works for both customer and driver, to show mesg for selecting customers for approval.
            // returns to driverapproval.blade.php to show the message that select the drivers to approve.
            return redirect()->back()->withErrors("Please Select Accounts to Approve/Reject!");
        }
    }

}