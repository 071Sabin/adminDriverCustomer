<?php

use App\Http\Controllers\Admin\admincontroller;
use App\Http\Controllers\Admin\ordercontroller;
use App\Http\Controllers\Driver\drivercontroller;

use App\Http\Controllers\Admin\approvalcontroller;
use App\Http\Controllers\Admin\commissioncontroller;
use App\Http\Controllers\Admin\minchargescontroller;
use App\Http\Controllers\Customer\customercontroller;
use App\Http\Controllers\Admin\deliveryratecontroller;
use App\Http\Controllers\Admin\driverwalletcontroller;
use App\Http\Controllers\Admin\adminbroadcastcontroller;
use App\Http\Controllers\Admin\customerwalletcontroller;
use App\Http\Controllers\Driver\driverprofilecontroller;
use App\Http\Controllers\Admin\individualdrivercontroller;
use App\Http\Controllers\Admin\individualcustomercontroller;
use App\Http\Controllers\Customer\customerprofilecontroller;
use App\Http\Controllers\Driver\driverdocverificationcontroller;
use App\Http\Controllers\Customer\customerdocverificationcontroller;

// use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');


// --------------------ADMIN------------------------
Route::prefix('admin')->group(function () {
    Route::get('/login', [admincontroller::class, 'adminlogin'])->name('adminlogin');
    Route::post('/login', [admincontroller::class, 'adminloginprocess']);

    // Route::get('/signup', [admincontroller::class, 'adminsignup'])->name('adminsignup');
    // Route::post('/signup', [admincontroller::class, 'adminsignupprocess']);

    Route::middleware(['auth:admin'])->group(function () {

        Route::get('/dashboard', [admincontroller::class, 'admindashboard'])->name('admindashboard');
        Route::get('/profile', [admincontroller::class, 'adminprofile'])->name('adminprofile');
        Route::get('/logout', [admincontroller::class, 'adminlogout'])->name('adminlogout');

        // controlling the broadcast messages for customer and drivers, returns to the admin dashboard though the 
        Route::post('/dashboard/custbroadcast', [adminbroadcastcontroller::class, 'customerbroadcast'])->name('admincustbroadcast');
        Route::post('/dashboard/driverbroadcast', [adminbroadcastcontroller::class, 'driverbroadcast'])->name('admindriverbroadcast');

        // delete broadcast from admin dashboard doesn't matter customer or driver
        Route::get('/dashboard/{deletebroadcastid}', [adminbroadcastcontroller::class, 'deletebroadcast'])->name('deletebroadcast');

        // THESE WILL JUST DISPLAY THE PENDING AND EXISTING ACCOUNTS FOR CUSTOMERS
        Route::get('/customer-approval', [approvalcontroller::class, 'customerapproval'])->name('customerapproval');
        // THIS IS TO APPROVE/REJECT THE DRIVER AND CUSTOMER SIGNUPS BY ADMIN, blade file form action of both customer/driver is calling this route name
        Route::post('/users-approval', [approvalcontroller::class, 'approvalprocess'])->name('approveprocess');
        Route::get('/customer-accounts', [admincontroller::class, 'customeraccounts'])->name('customeraccounts');


        // now clicking individual custId and then seeing the individual details of them.
        Route::get('/customer-account/show/{custid}', [individualcustomercontroller::class, 'showEachCustomerDetails'])->name('showIndividualCustomerDetails');

        Route::get('/driver-account/show/{driverid}', [individualdrivercontroller::class, 'showEachDriverDetails'])->name('showIndividualDriverDetails');

        // admin update the customer details, related to individualCustomerDetails.blade.php
        Route::post('/customer-account/update/{custid}', [individualcustomercontroller::class, 'adminUpdateCustomerDetails'])->name('adminUpdateCustomerDetails');

        // admin update the driver details, related to individualDriverDetails.blade.php
        Route::post('/driver-account/update/{custid}', [individualdrivercontroller::class, 'adminUpdateDriverDetails'])->name('adminUpdateDriverDetails');

        // after clicking approve button in induvidualCustomerDetails.blade.php, user verification_status will be updated to 1.
        Route::get('/customer-account/approve-kyc/{custid}', [individualcustomercontroller::class, 'AdminKycApprove'])->name('AdmincustKycApprove');
        Route::get('/customer-account/reject-kyc/{custid}', [individualcustomercontroller::class, 'AdminKycReject'])->name('AdmincustKycReject');

        Route::get('/driver-account/approve-kyc/{driverid}', [individualdrivercontroller::class, 'AdminKycApprove'])->name('AdmindriverKycApprove');
        Route::get('/driver-account/reject-kyc/{driverid}', [individualdrivercontroller::class, 'AdminKycReject'])->name('AdmindriverKycReject');



        // show and update customer wallet
        Route::get('/customer-wallet', [customerwalletcontroller::class, 'customerwallet'])->name('customerwallet');

        // {walletid} this is just a variable, we can write anything here, it takes the value passed from the blade file.
        // this is to show one customer at a time clicking their walletid.
        Route::get('/customer-wallet/{walletid}', [customerwalletcontroller::class, 'IndividualCustWallet'])->name('IndividualCustWallet');
        Route::put('/customer-wallet/{walletid}', [customerwalletcontroller::class, 'updateIndividualCustWallet']);

        // showing the pending driver approval and driver existing accounts.
        Route::get('/driver-approval', [approvalcontroller::class, 'driverapproval'])->name('driverapproval');
        Route::get('/driver-accounts', [admincontroller::class, 'driveraccounts'])->name('driveraccounts');

        // show and update driver wallet
        Route::get('/driver-wallet', [driverwalletcontroller::class, 'driverwallet'])->name('driverwallet');

        // update customer balance whose walletid is clicked.
        Route::get('/driver-wallet/{walletid}', [driverwalletcontroller::class, 'IndividualDriverWallet'])->name('IndividualDriverWallet');
        Route::put('/driver-wallet/{walletid}', [driverwalletcontroller::class, 'updateIndividualDriverWallet']);

        // show all orders from customer
        Route::get('/orders', [ordercontroller::class, 'allorders'])->name('allorders');

        // show and update rate per mile
        Route::get('/rate-per-mile', [deliveryratecontroller::class, 'ratepermile'])->name('ratepermile');
        Route::post('/rate-per-mile', [deliveryratecontroller::class, 'update_ratepermile']);

        // show and update the minimum charge
        Route::get('/minimum-charge', [minchargescontroller::class, 'show_min_charge'])->name('showmincharge');
        Route::post('/minimum-charge', [minchargescontroller::class, 'set_min_charge']);

        // show and update the commission rate
        Route::get('/commission-rate', [commissioncontroller::class, 'show_com_rate'])->name('showcomrate');
        Route::post('/commission-rate', [commissioncontroller::class, 'set_com_rate']);
    });
});


// --------------------CUSTOMER------------------------
Route::prefix('customer')->group(function () {
    // show login page
    Route::get('/login', [customercontroller::class, 'customerlogin'])->name('customerlogin');
    // process the login details, checking in db and all backend
    Route::post('/login', [customercontroller::class, 'customerloginprocess']);

    // same as login above
    Route::get('/signup', [customercontroller::class, 'customersignup'])->name('customersignup');
    Route::post('/signup', [customercontroller::class, 'customersignupprocess']);

    // to authenticate the user and then give access to these routes.
    Route::middleware(['auth:customer'])->group(function () {
        Route::get('/dashboard', [customercontroller::class, 'customerdashboard'])->name('customerdashboard');

        // CUSTOMER PROFILE PAGE
        Route::get('/profile', [customerprofilecontroller::class, 'customerprofile'])->name('customerprofile');
        // updating customer details by customer only
        Route::post('/profile-update', [customerprofilecontroller::class, 'UpdateCustomerDetails'])->name('UpdateCustomerDetails');

        // uploading customer profile picture
        Route::post('/profile-pic-update', [customerprofilecontroller::class, 'upload_customer_profile_pic'])->name('upload_customer_profile_pic');
        // delete customer profile picture
        Route::get('/profile-pic-delete', [customerprofilecontroller::class, 'delete_customer_profile_pic'])->name('delete_cust_profile_pic');

        // verification document upload post method for customer either driving lisence, adharcard or pancard, name of route can be anything, for easyness i put the same name as the function in controller.
        Route::post('/cust-doc-verification', [customerdocverificationcontroller::class, 'customerDocVerification'])->name('customerDocVerification');

        // customer deleting their uploaded files, smetimes there may be some mistakes.
        Route::get('/cust-delete-verificationfile', [customerdocverificationcontroller::class, 'CustomerDeleteVerificationFile'])->name('CustomerDeleteVerificationFile');
        Route::get('/logout', [customercontroller::class, 'customerlogout'])->name('customerlogout');

    });
});


// --------------------DRIVER------------------------
Route::prefix('driver')->group(function () {
    Route::get('/login', [drivercontroller::class, 'driverlogin'])->name('driverlogin');
    Route::post('/login', [drivercontroller::class, 'driverloginprocess']);

    Route::get('/signup', [drivercontroller::class, 'driversignup'])->name('driversignup');
    Route::post('/signup', [drivercontroller::class, 'driversignupprocess']);

    Route::middleware(['auth:driver'])->group(function () {
        Route::get('/dashboard', [drivercontroller::class, 'driverdashboard'])->name('driverdashboard');

        // just show the profile page for drivers.
        Route::get('/profile', [driverprofilecontroller::class, 'driverprofile'])->name('driverprofile');

        // updating driver details by drivers only
        Route::post('/profile-update', [driverprofilecontroller::class, 'UpdateDriverDetails'])->name('UpdateDriverDetails');

        // uploading driver profile picture
        Route::post('/profile-pic-update', [driverprofilecontroller::class, 'upload_driver_profile_pic'])->name('upload_driver_profile_pic');
        // delete driver profile picture
        Route::get('/profile-pic-delete', [driverprofilecontroller::class, 'delete_driver_profile_pic'])->name('delete_driver_profile_pic');


        // verification document upload post method for customer either driving lisence, adharcard or pancard, name of route can be anything, for easyness i put the same name as the function in controller.
        Route::post('/driver-doc-verification', [driverdocverificationcontroller::class, 'driverDocVerification'])->name('driverDocVerification');

        // customer deleting their uploaded files, smetimes there may be some mistakes.
        Route::get('/driver-delete-verificationfile', [driverdocverificationcontroller::class, 'driverDeleteVerificationFile'])->name('driverDeleteVerificationFile');
        Route::get('/logout', [drivercontroller::class, 'driverlogout'])->name('driverlogout');
    });
});