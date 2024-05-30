<?php

namespace App\Http\Controllers\Admin;

use App\Driver;
use App\wallets;
use App\Customer;
use App\transactions;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


// this controller includes all the wallets with transactions db storage for each transactions.
class customerwalletcontroller extends Controller
{
    // show all the customer details with their walletid in table, this fn works on customerwallet.blade.php file and shows all the cust details with walletid.
    // >> each walletid is clickable and passing the walletid variable to url in web.php {walletid} using <a> tag in the same table.
    // just the get() method in web.php, to show the details of all customers.
    public function customerwallet()
    {
        // we are not putting conditions to count the DB records and just passing the available combinations with join clause.
        // all the counting part and conditions are done in customerwallet.blade.php file. because if we put the condition of counting in both this file and blade file, it will cause the variable error as some variables are passed when the if..else condition meets. but the same variable is accessed in same ifelse condition in blade file. so it collides sometimes. better put condition in either one of the file

        // using traditional code to get the rrelationship betn customer and wallets. see the wallets.php model to see how it's done.
        // $cust_wallet1 = DB::table('customer')
        //     ->join('wallets', 'customer.custId', '=', 'wallets.user_id')
        //     ->select('customer.id', 'customer.custId', 'wallets.wallet_id', 'customer.name', 'customer.email', 'customer.phone', 'wallets.balance')
        //     ->get();

        // refer to customerwallet.blade.php to see how it is referenced.
        $cust_wallet1 = Customer::with('wallet')->where('approved_status', '=', 1)->get();

        //if there are just customers approved but not wallet id, checking for that

        // foreach ($cust_wallet1 as $customer) {
        //     // Check if the wallet exists for the customer
        //     if (!$customer->wallet) {
        //         // Wallet does not exist, handle this case
        //         // For example, display a message or perform other actions
        //         $customerId = $customer->id;
        //         $customerName = $customer->name;
        //         // Inform the user that their wallet is missing
        //         echo "Wallet for customer $customerName (ID: $customerId) is not created.";
        //     }
        // }

        // >> return to this blade file, with the cust_wllet1 variable above.

        return view('admin.customerwallet', compact('cust_wallet1'));


    }

    // get() method in web.php, to show details of single customer with form to update balance
    // above fn customerwallet() shows cust details with walletid  in a table. each walletid is clickable.
    // >> walletid clicked >> walletid passed to url using <a> tag >> walletid is automatic accessed by this function and stored in $wallet variable. as passing a variable to url is automatically accessed by the function to that particular url.
    // don't be confused that how is it accessible, the walletid is passed to url by using <a> tag from the table above using href="{{ route('IndividualCustWallet', $wallet->wallet_id) }}" [file - customerwallet.blade.php]
    // >> this is for get() method in web.php, just to show single cust details with that walletid and form to update balance.
    // >> [individualCustWallet.blade.php file after clicking a walletid.]
    public function IndividualCustWallet(Request $request, $wallet)
    {
        // finding the current customer details and showing in blade file.
        $custWalletDetails = DB::table('customer')
            ->join('wallets', 'user_id', '=', 'customer.custId')
            ->where('wallets.wallet_id', '=', $wallet)
            ->select(
                'customer.custId',
                'customer.name',
                'customer.email',
                'customer.phone',
                'wallets.balance',
                'wallets.wallet_id'
            )
            ->get();

        // to show transactions of single customer in a table format
        $custTransDetails = DB::table('wallets')
            ->rightJoin('transactions', 'transactions.wallet_id', 'wallets.wallet_id')
            ->where('transactions.wallet_id', '=', $wallet)
            ->get();
        // dd($custTransDetails);
        return view('admin.individualCustWallet', compact('custWalletDetails', 'custTransDetails'));
    }

    // post/put() method in web.php to update balance for that particular customer.
    // >> $wallet is the same walletid from the url, take it and then update the balance for the same customer.
    // >> enter add/remove and function will check the rest.
    // >> [individualCustWallet.blade.php file after clicking a walletid, below fn is to update so post/put method]
    public function updateIndividualCustWallet(Request $request, $wallet)
    {
        $request->validate([
            'newbalance' => 'required',
            'transaction_status' => 'required',
            'transaction_type' => 'required',
            'currency' => 'required',
        ], [
            'newbalance' => 'new balance has to be greater than 1.',
            'transaction_status' => 'Transaction status not defined!',
            'transaction_type' => 'Transaction type not defined',
            'currency' => 'currency not defined',
        ]);
        // taking the input balance
        $newbalance = $request->input('newbalance');

        $transType = $request->input('transaction_type');
        $currency = $request->input('currency');
        $transStatus = $request->input('transaction_status');
        $transDesc = $request->input('description');

        // taking the value property from the add/remove btn in file individualCustWallet.blade.php, both add/remove btn has same name 'updatebalance' and value is taken from there.
        $addremovebalance = $request->input('btn_updatebalance');

        // taking the 'balance' column value using value() fn. to add/subtract the entered value.
        $oldbalance = DB::table('wallets')->where('wallet_id', $wallet)->value('balance');

        // adding and removing balance
        if ($newbalance > 0) {
            if ($addremovebalance === 'add') {

                $totalbalance = (float) $oldbalance + (float) $newbalance;
                DB::table('wallets')->where('wallet_id', $wallet)->update(['balance' => $totalbalance]);

                // now we need to update each transactions to the table with userid.

                $time = now()->timestamp;
                $random = mt_rand(100000, 999999);
                $combinedString = $random . $time;
                $unique_tid = 't-' . Str::limit(md5($combinedString), 8, '');

                $transactionTable = new transactions();
                $transactionTable->transaction_id = $unique_tid;
                $transactionTable->user_id = wallets::where('wallet_id', $wallet)->value('user_id');
                $transactionTable->wallet_id = $wallet;
                $transactionTable->user_type = wallets::where('wallet_id', $wallet)->value('user_type');
                $transactionTable->transaction_type = $transType;
                $transactionTable->status = $transStatus;
                $transactionTable->previous_balance = $oldbalance;
                $transactionTable->updated_balance = $totalbalance;
                $transactionTable->currency = $currency;
                $transactionTable->description = $transDesc;

                $transactionTable->save();


                // returning back to admin/individualcustomerwallet.blade.php with the session and session is passing a variable $newbalance. 
                return back()->with('addsuccess', $newbalance);
            }

            // remove/subtract the balance, check the condition if the balance is in negative after subtraction.
            elseif ($addremovebalance === 'remove') {

                $totalbalance = 0;
                $totalbalance = $oldbalance - $newbalance;

                if ($totalbalance < 0) {
                    // return back to admin/individualcustomerwallet.blade.php with error.
                    return back()->withErrors('sorry, the balance cannot be updated because it will be in negative while removing. Please try again with lower value than the balance shown above!');
                } else {
                    DB::table('wallets')->where('wallet_id', $wallet)->update(['balance' => $totalbalance]);
                    // dd("need to remove the balance" . $newbalance);
                    $time = now()->timestamp;
                    $random = mt_rand(100000, 999999);
                    $combinedString = $random . $time;
                    $unique_tid = 't-' . Str::limit(md5($combinedString), 8, '');

                    $transactionTable = new transactions();
                    $transactionTable->transaction_id = $unique_tid;
                    $transactionTable->user_id = wallets::where('wallet_id', $wallet)->value('user_id');
                    $transactionTable->wallet_id = $wallet;
                    $transactionTable->user_type = wallets::where('wallet_id', $wallet)->value('user_type');
                    $transactionTable->transaction_type = $transType;
                    $transactionTable->status = $transStatus;
                    $transactionTable->previous_balance = $oldbalance;
                    $transactionTable->updated_balance = $totalbalance;
                    $transactionTable->currency = $currency;
                    $transactionTable->description = $transDesc;

                    $transactionTable->save();
                    // returning back with the session and session is passing a variable $newbalance. this is catched in individualCustWallet.blade.php
                    return back()->with('removesuccess', $newbalance);
                }
            }
        } else {

            // admin/individualcustomerwallet.blade.php this is where it returns back()
            // if the input balance in input field is not greater than zero, then show this message. but the conditions in validate() method is proritized over this error.
            return back()->withErrors("Please enter balance greater than ZERO.");
        }
        // if there is any other error occurs, preventing from showing the system error. admin/individualcustomerwallet.blade.php
        return back()->withErrors('There is something error!!');
    }

    public function testing()
    {
        $allcustomerDb = Customer::with('wallet')->get();
        foreach ($allcustomerDb as $c) {
            dump("Name: " . $c->name);
            dump("email: " . $c->email);
            dump("phone: " . $c->phone);

            if ($c->wallet) {
                // echo 'walletid: ' . $c->$wallet->wallet_id;
                dump("walletid: " . $c->wallet->wallet_id);
            } else {
                echo 'something wrong with walletid';
            }
        }
    }
}