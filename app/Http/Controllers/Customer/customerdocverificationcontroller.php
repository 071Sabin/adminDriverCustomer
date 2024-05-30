<?php

namespace App\Http\Controllers\Customer;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class customerdocverificationcontroller extends Controller
{

    // this controller contains all the operations performed in customer profile that is related to kyc verification part.
    // if user deletes the verification file and all are here, this is just for kyc verification, uploading kyc document by customers.
    // customerDocVerification function is if the user uploads the kyc file.
    public function customerDocVerification(request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:jpeg,png,jpg',
            'documentType' => 'required',

        ], [
            'document.required' => "Please upload your document for verification.",
            'documentType.required' => "What is your document type for verification?",
        ]);



        $document = $request->file('document')->store('customer_verification_doc');

        $custTable = Auth::guard('customer')->user();
        $custTable->verification_file = $document;
        $custTable->verification_type = $request->input('documentType');

        // making these null again because if something happens from admin side directly from DB, reuploading the file will solve the problem
        // for eg: if in DB, we delete some values or some fields, then this will do it, this is the main thing where issue may occur.

        $custTable->verification_status = 0;
        $custTable->kyc_rejection = null;

        $custTable->save();

        // returns to customer/customerprofile.blade.php
        return back()->with('doc_upload_success', true);
    }

    public function CustomerDeleteVerificationFile(request $request)
    {
        // dd('testing deleting customer kyc');
        $currentCustomer = Auth::guard('customer')->user();

        $verificationFile = $currentCustomer->verification_file;

        // delete fn called when custome clicks the delete icon in customerprofile.blade.php
        Storage::delete($verificationFile);
        // dd(Storage::exists($verificationFile));

        // after deleting, update the file and type column, restore every fields to default
        $currentCustomer->verification_file = null;
        $currentCustomer->verification_type = null;
        $currentCustomer->verification_status = 0;
        $currentCustomer->kyc_rejection = null;
        $currentCustomer->save();

        // returns to customer profile.
        return back()->with('cust_verification_file_deleted', true);
    }
}