<?php

namespace App\Http\Controllers\Admin;

use App\broadcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class adminbroadcastcontroller extends Controller
{
    public function customerbroadcast(request $request)
    {
        $request->validate(
            [
                'custBroadcastmesg' => 'required',
                'custBroadcastTitle' => 'required',
                'messageUrgency' => 'required',
            ],
            [
                'custBroadcastTitle.required' => 'What is the title of your broadcast for customers?',
                'messageUrgency.required' => 'Please select a message type for customer!',
                'custBroadcastmesg.required' => 'Please write some message for customer!',
            ]
        );

        $b = new broadcast();
        $b->adminId = Auth::guard('admin')->user()->id;

        $b->broadcast_type = $request->messageUrgency;
        $b->for = 'customer';
        $b->message = $request->custBroadcastmesg;
        $b->broadcast_title = $request->custBroadcastTitle;

        $b->save();

        // returns to admin dashboard with the sessions and message separated by comma for customer
        //  then display the message given.
        return back()->with('cust_broadcast_success', 'Message broadcast success for customers.');
    }

    public function driverbroadcast(request $request)
    {
        $request->validate(
            [
                'driverBroadcastmesg' => 'required',
                'messageUrgency' => 'required',
                'driverBroadcastTitle' => 'required',
            ],
            [
                'driverBroadcastTitle.required' => 'What is the title of your broadcast for drivers?',
                'messageUrgency.required' => 'Please select a message importance for driver!',
                'driverBroadcastmesg.required' => 'Please write some message for driver!',
            ]
        );

        $b = new broadcast();

        $b->adminId = Auth::guard('admin')->user()->id;
        $b->broadcast_type = $request->messageUrgency;
        $b->for = 'driver';
        $b->message = $request->driverBroadcastmesg;
        $b->broadcast_title = $request->driverBroadcastTitle;
        $b->save();

        // return to admindashboard.blade.php for driver broadcast success mesg
        return back()->with('driver_broadcast_success', 'Message broadcast success for drivers.');
    }

    public function deletebroadcast($broadcast_id)
    {
        // broadcast::findOrFail($broadcast_id)->delete();

        // dump($broadcast_id);
        broadcast::findOrFail($broadcast_id)->delete();

        // returns to admindashboard.blade.php to show the message for deleted broadcast.
        return back()->with('broadcast_deleted', $broadcast_id);
    }
}