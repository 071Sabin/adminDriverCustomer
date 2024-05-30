<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin';
    protected $primaryKey = 'id';
    protected $timestamp = true;

    public function adminbroadcast()
    {
        return $this->hasMany(broadcast::class, 'adminId', 'id');
    }
}