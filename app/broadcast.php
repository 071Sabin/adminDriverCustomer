<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class broadcast extends Model
{
    protected $table = 'broadcast';
    protected $primaryKey = 'id';
    protected $timestamp = true;
}