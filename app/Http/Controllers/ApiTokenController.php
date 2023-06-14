<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiTokenRequest;
use App\Models\ApiToken;
use Illuminate\Support\Str;

class ApiTokenController extends Controller
{
    public function __invoke(ApiTokenRequest $request)
    {

        $token = (string)Str::uuid();

        $email = $request->validated()['email'];

        $apiToken = ApiToken::where('email', $email)->first();

        if ($apiToken) return response()->json(['error' => 'Email already have an apiToken'], 422);

        ApiToken::create(['token' => $token, 'email' => $email]);
        return  $token;
    }
}
