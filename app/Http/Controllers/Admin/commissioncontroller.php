<?php

namespace App\Http\Controllers\Admin;

use App\commissionrate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class commissioncontroller extends Controller
{
    // get method to show the commissionrate web page.
    public function show_com_rate()
    {
        // finding the first column with id=1. we don't need any other row for commission rates but still we have different table for commission rate to keep our application organized.
        $commissionRates = commissionrate::where('id', '=', 1)->get();
        // 'comm' using this variable we can access the $commissionRates in blade file.
        return view('admin.commissionrate', ['comm' => $commissionRates]);
    }

    // post method to update the commission rate.

    public function set_com_rate(request $request)
    {
        $request->validate([
            "commrate" => "required",
        ]);

        $com_table = commissionrate::findOrFail(1);
        $newcommrate = $request->input('commrate');
        $currentcommrate = $com_table->current_com_rate;

        if ($newcommrate == $currentcommrate) {
            // returns to admin/commissionrate.blade.php
            return back()->withErrors("Value matches to Current Commission Rate! Try higher or lower value.");
        } else {
            $com_table->last_com_rate = $com_table->current_com_rate;
            $com_table->current_com_rate = $newcommrate;

            $com_table->save();

            // returns to admin/commissionrate.blade.php
            return back()->with("success", $newcommrate);
        }
    }
}