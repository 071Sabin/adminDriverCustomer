<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    protected $table = 'customer';
    protected $primaryKey = 'id';
    protected $timestamp = true;

    public function wallet()
    {
        // a customer hasOne wallet so using this we can access the current authenticated user wallet details.
        // customer is authenticated using customer table so creating a relation betn customer and wallet
        return $this->hasOne(wallets::class, 'user_id', 'custId');
    }

    public function transactions()
    {
        // a customer will have many transactions
        // accessing transaction details of a single relation using hasMany fn
        return $this->hasMany(transactions::class, 'transaction_id', 'custId');
    }

    public function orders()
    {
        return $this->hasMany(orders::class, 'orderId', 'custId');
    }

}