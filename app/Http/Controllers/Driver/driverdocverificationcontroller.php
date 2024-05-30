<?php

namespace App\Http\Controllers\Driver;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;


class driverdocverificationcontroller extends Controller
{
    public function driverDocVerification(request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:jpeg,png,jpg',
            'documentType' => 'required',

        ], [
            'document.required' => "Please upload your document for verification.",
            'documentType.required' => "What is your document type for verification?",
        ]);



        $document = $request->file('document')->store('driver_verification_doc');

        $driverTable = Auth::guard('driver')->user();
        $driverTable->verification_file = $document;
        $driverTable->verification_type = $request->input('documentType');

        // making these null again because if something happens from admin side directly from DB, reuploading the file will solve the problem
        // for eg: if in DB, we delete some values or some fields, then this will do it, this is the main thing where issue may occur.

        $driverTable->verification_status = 0;
        $driverTable->kyc_rejection = null;
        $driverTable->save();

        // returns to driver/driverprofile.blade.php
        return back()->with('doc_upload_success', true);
    }

    public function driverDeleteVerificationFile(request $request)
    {
        $currentDriver = Auth::guard('driver')->user();

        $verificationFile = $currentDriver->verification_file;

        // delete fn called when driver clicks the delete icon in driverprofile.blade.php
        Storage::delete($verificationFile);
        // dd(Storage::exists($verificationFile));

        // after deleting, update the file and type column, restore every fields to default
        $currentDriver->verification_file = null;
        $currentDriver->verification_type = null;
        $currentDriver->verification_status = 0;
        $currentDriver->kyc_rejection = null;
        $currentDriver->save();

        // returns to cusotmer profile.
        return back()->with('driver_verification_file_deleted', true);
    }
}