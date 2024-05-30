<?php

namespace App\Http\Controllers\Admin;

use App\Driver;
use App\wallets;
use App\transactions;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


// this controller shows and updates individual driver wallet
class driverwalletcontroller extends Controller
{
    // show all the driver details with walletid in driverwallet.blade.php using get() method in web.php
    // shows driver details in a table with clickable walletid for each.
    public function driverwallet()
    {
        // extracting customer details using the user_id from wallets table and driverId in driver table using traditional joins.
        // $driver_wallets = DB::table('driver')
        //     ->join('wallets', 'driver.driverId', '=', 'wallets.user_id')
        //     ->select('driver.id', 'driver.driverId', 'wallets.wallet_id', 'driver.name', 'driver.email', 'driver.phone', 'wallets.balance')
        //     ->get();

        // same as above/modern method, it will look into the wallets model, looks the hasOne function there we gave relation that we will be joining these table on the basis of custId and wallet's user_id.
        $driver_wallets = Driver::with('driverwallet')->where('approved_status', '=', 1)->get();
        // dd($driver_wallets);

        return view('admin.driverwallet', compact('driver_wallets'));
    }

    public function IndividualDriverWallet(Request $request, $wallet)
    {
        // finding the current customer details and showing in blade file.
        $driverWalletDetails = DB::table('driver')
            ->join('wallets', 'user_id', '=', 'driver.driverId')
            ->where('wallets.wallet_id', '=', $wallet)
            ->select(
                'driver.driverId',
                'driver.name',
                'driver.email',
                'driver.phone',
                'wallets.balance',
                'wallets.wallet_id'
            )
            ->get();

        // to show transactions of single customer in a table format
        $driverTransDetails = DB::table('wallets')
            ->rightJoin('transactions', 'transactions.wallet_id', 'wallets.wallet_id')
            ->where('transactions.wallet_id', '=', $wallet)
            ->get();
        // dd($driverTransDetails);
        return view('admin.individualDriverWallet', compact('driverWalletDetails', 'driverTransDetails'));
    }

    // post/put() method in web.php to update balance for that particular customer.
    // >> $wallet is the same walletid from the url, take it and then update the balance for the same customer.
    // >> enter add/remove and function will check the rest.
    // >> [individualCustWallet.blade.php file after clicking a walletid, below fn is to update so post/put method]
    public function updateIndividualDriverWallet(Request $request, $wallet)
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


                // returning back with the session and session is passing a variable $newbalance. this is catched in individualCustWallet.blade.php
                return back()->with('addsuccess', $newbalance);
            }

            // remove/subtract the balance, check the condition if the balance is in negative after subtraction.
            elseif ($addremovebalance === 'remove') {

                $totalbalance = 0;
                $totalbalance = $oldbalance - $newbalance;

                if ($totalbalance < 0) {
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
            // if the input balance in input field is not greater than zero, then show this message. but the conditions in validate() method is proritized over this error.
            return back()->withErrors("Please enter balance greater than ZERO.");
        }
        // if there is any other error occurs, preventing from showing the system error.
        return back()->withErrors('There is something error!!');
    }

    public function testing()
    {
        $allcustomerDb = Driver::with('wallet')->get();
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