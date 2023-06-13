<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ApiToken extends Model
{
    protected $fillable = ['token'];
}
