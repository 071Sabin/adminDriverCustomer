<?php

namespace App;

use App\Driver;
use App\Customer;
use Illuminate\Database\Eloquent\Model;

class wallets extends Model
{
    protected $table = 'wallets';
    protected $primaryKey = 'id';
    protected $timestamp = true;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'custId', 'user_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driverId', 'user_id');
    }
}