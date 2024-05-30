<?php

namespace App\Http\Controllers\Admin;

use App\mincharge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class minchargescontroller extends Controller
{
    public function show_min_charge()
    {
        if (Auth::guard('admin')->check()) {
            $getrate = mincharge::where('id', '=', 1)->get();
            return view('admin.mincharges', ['charge' => $getrate]);
        }
    }

    public function set_min_charge(request $request)
    {
        $request->validate([
            'charge' => 'required',
        ]);

        // ratepermile get the first row that is seeded using databaseseeder.
        $m = mincharge::findOrFail(1);

        $newmincharge = $request->input('charge');
        $currentmincharge = $m->current_min_charge;

        // swapping the value from current->last-charge,,,, inputdata->current_charge
        if ($newmincharge == $currentmincharge) {

            // returns to admin/mincharges.blade.php, this is catched with @if errors
            return back()->withErrors("Value matches the current min. charge! Try higher or lower value.");
        } else {
            $m->last_min_charge = $m->current_min_charge;
            $m->current_min_charge = $newmincharge;

            $m->save();

            // returning back to the same page with success message
            return redirect()->back()->with('success', $newmincharge);
        }
    }
}