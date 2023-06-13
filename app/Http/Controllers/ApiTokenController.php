<?php

namespace App\Http\Controllers;

use App\Models\ApiToken;
use Illuminate\Support\Str;

class ApiTokenController extends Controller
{
    public function __invoke()
    {
        $token = (string)Str::uuid();
        ApiToken::create(['token' => $token]);
        return  $token;
    }
}
