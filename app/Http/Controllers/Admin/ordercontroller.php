<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ordercontroller extends Controller
{
    public function allorders()
    {
        if (Auth::guard('admin')->check()) {

            // we can also write as: orders->get,,, and the orders class should be imported
            $orders = DB::table('orders')
                ->get();
            return view('admin.orders', ['vieworders' => $orders]);
        }
    }

    public function createorders(request $request)
    {
        $request->validate([

        ]);
    }
}