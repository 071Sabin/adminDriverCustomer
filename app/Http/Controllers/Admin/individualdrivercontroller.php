<?php

namespace App\Http\Controllers\Admin;

use App\Driver;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class individualdrivercontroller extends Controller
{
    // this controller is for individualDriverDetails.blade.php that will show each driver details after clicking the driverId from table
    // the table where all the drivers are displayed, that get method is in admincontroller.php
    // this controller handles the showing individual driver details with the uploaded kyc file, approve and reject that kyc file along with editing the user details like name, email, phone
    public function showEachDriverDetails(request $request, $driverId)
    {
        // dd($driverId);
        $driverDetails = Driver::where('driverId', $driverId)->first();
        return view('admin.individualDriverDetails', compact(('driverDetails')));
    }

    public function adminUpdateDriverDetails(request $request, $driverId)
    {
        // these are from individualDriverDetails.blade.php
        $currentIndividualDriver = Driver::where('driverId', $driverId)->first();
        $updatedUsername = $request->updatedName;
        $updatedEmail = $request->updatedEmail;
        $updatedPhone = $request->updatedPhone;

        // only updating those part that is filled. 

        if ($updatedUsername) {
            $currentIndividualDriver->name = $updatedUsername;
            $currentIndividualDriver->save();
            // $enteredDetails = $enteredDetails . ' Username';
        }
        if ($updatedPhone) {
            $currentIndividualDriver->phone = $updatedPhone;
            $currentIndividualDriver->save();
            // $enteredDetails = $enteredDetails . ' Phone';
        }

        if ($updatedEmail) {
            $currentIndividualDriver->email = $updatedEmail;
            $currentIndividualDriver->save();
            // $enteredDetails = $enteredDetails . ' Email';
        }
        // dd($enteredDetails);

        // returns to individualDriverDetails.blade.php
        return back()->with('driver_details_updated', true);
    }

    public function AdminKycApprove(request $request, $driverId)
    {
        Driver::where('driverId', $driverId)->update(['verification_status' => 1, 'kyc_rejection' => 0]);

        // dd($driverId);

        // returns to individualDriverDetails.blade.php
        return back()->with('driver_approved_by_admin', true);
    }

    public function AdminKycReject(request $request, $driverId)
    {
        // updating the columns if admin rejects the kyc document,, more details in individualDriverDetails.blade.php that how to check the validation of approve and all.
        Driver::where('driverId', $driverId)->update(['verification_status' => 0, 'kyc_rejection' => 1]);

        // dd($driverId);

        // returns to individualDriverDetails.blade.php
        return back()->with('driver_rejected_by_admin', true);
    }
}