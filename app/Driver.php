<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Driver extends Authenticatable
{
    protected $table = 'driver';
    protected $primaryKey = 'id';
    protected $timestamp = true;

    public function driverwallet()
    {
        return $this->hasOne(wallets::class, 'user_id', 'driverId');
    }
}