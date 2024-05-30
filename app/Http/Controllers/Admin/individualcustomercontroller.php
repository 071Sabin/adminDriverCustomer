<?php

namespace App\Http\Controllers\Admin;

use App\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class individualcustomercontroller extends Controller
{
    // this controller is for individualcustomerDetails.blade.php that will show each customer details after clicking the custId from table
    // the table where all the customers are displayed, that get method is in admincontroller.php
    // this controller handles the showing individual customer details with the uploaded kyc file, approve and reject that kyc file along with editing the user details like name, email, phone
    public function showEachCustomerDetails(request $request, $customerId)
    {
        // dd($customerId);
        $customerDetails = Customer::where('custId', $customerId)->first();
        return view('admin.individualCustomerDetails', compact(('customerDetails')));
    }

    public function adminUpdateCustomerDetails(request $request, $customerId)
    {
        // these are from individualCustomerDetails.blade.php
        $currentIndividualCustomer = Customer::where('custId', $customerId)->first();
        $updatedUsername = $request->updatedName;
        $updatedEmail = $request->updatedEmail;
        $updatedPhone = $request->updatedPhone;

        // only updating those part that is filled. 

        if ($updatedUsername) {
            $currentIndividualCustomer->name = $updatedUsername;
            $currentIndividualCustomer->save();
            // $enteredDetails = $enteredDetails . ' Username';
        }
        if ($updatedPhone) {
            $currentIndividualCustomer->phone = $updatedPhone;
            $currentIndividualCustomer->save();
            // $enteredDetails = $enteredDetails . ' Phone';
        }

        if ($updatedEmail) {
            $currentIndividualCustomer->email = $updatedEmail;
            $currentIndividualCustomer->save();
            // $enteredDetails = $enteredDetails . ' Email';
        }
        // dd($enteredDetails);

        // returns to individualCustomerDetails.blade.php
        return back()->with('customer_details_updated', true);
    }

    public function AdminKycApprove(request $request, $customerId)
    {
        Customer::where('custId', $customerId)->update(['verification_status' => 1, 'kyc_rejection' => 0]);

        // dd($customerId);

        // returns to individualCustomerDetails.blade.php
        return back()->with('customer_approved_by_admin', true);
    }

    public function AdminKycReject(request $request, $customerId)
    {
        // updating the columns if admin rejects the kyc document,, more details in individualCustomerDetails.blade.php that how to check the validation of approve and all.
        Customer::where('custId', $customerId)->update(['verification_status' => 0, 'kyc_rejection' => 1]);

        // dd($customerId);

        // returns to individualCustomerDetails.blade.php
        return back()->with('customer_rejected_by_admin', true);
    }
}