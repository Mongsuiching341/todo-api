<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\JwtToken;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {

        $validated =  $request->validate([
            'name' => 'required|max:100',
            'email' => 'required',
            'password' => 'required|min:4',
        ]);

        $user =  User::create($validated);

        if ($user) {
            return response()->json(['msg' => 'user created succesfully', 'status' => 'success']);
        } else {
            return response()->json(['msg' => 'user created succesfully', 'status' => 'success']);
        }
    }

    //user login//

    public function login(Request $request)
    {

        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        $password = $request->input('password');

        if ($user && Hash::check($password, $user->password)) {

            //create token-----------
            $token =   JwtToken::createToken($user->id, $user->email);

            return response()->json(['msg' => 'logged in', 'status' => 'success'])->cookie('token', $token, 60 * 24 * 30);
        } else {
            return response()->json(['msg' => 'invalid cradentials', 'status' => 'failed']);
        }
    }
}
