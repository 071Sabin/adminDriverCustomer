<?php

namespace App\Http\Controllers\Admin;

use App\ratepermile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class deliveryratecontroller extends Controller
{
    public function ratepermile()
    {
        if (Auth::guard('admin')->check()) {
            $currentrate = DB::table('ratepermile')->where('id', '=', 1)->get();

            // rate here in below line is the variable that is going to be used in blade file in foreach loop.
            return view('admin.ratepermile', ['rate' => $currentrate]);
        }
    }
    public function update_ratepermile(request $request)
    {
        $request->validate([
            'rate' => 'required',
        ]);

        // $rr = ratepermile::where('id', '=', 1)->first();
        $r = ratepermile::findOrFail(1);

        $newrate = $request->input('rate');
        $currentrate = $r->current_rate;

        if ($newrate == $currentrate) {
            // returns to admin/ratepermile.blade.php
            return back()->withErrors("Value matches the Current Rate! Try higher or lower value.");
        } else {
            $r->last_rate = $r->current_rate;
            $r->current_rate = $newrate;

            $r->save();

            // returns to admin/ratepermile.blade.php
            return back()->with('success', $newrate);
        }
    }
}