<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'name' => 'required',
            'password' => 'required',
            'phone'=> 'required',
            'city'=> 'required'
        ]);
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->city = $request->city;
        $user->province = $request->province;
        $user->role_id = $request->role_id;
        $user->is_active = 1;

        $user->password = bcrypt($request->password);


        $tokenRequest = Request::create('/oauth/token', 'post', [
            'grant_type' => 'password',
            'client_id' => '2',
            'client_secret' => 'y3NGoiJPZoAj7ptKwmWjSiDsv8mJ2YboOhlN5oBE',
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '',
        ]);

        $response = app()->handle($tokenRequest);

        if ($user->save()) return response(['message' => 'Register Success!', 'status' => true]);
        return response(['message' => 'Register Failure!', 'status' => false]);

    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response(['token_type' => 'error', 'message' => 'User not found']);
        }

        if (Hash::check($request->password, $user->password)) {
            $tokenRequest = Request::create('/oauth/token', 'post', [
                'grant_type' => 'password',
                'client_id' => '2',
                'client_secret' => $request->client_secret,
                'username' => $request->email,
                'password' => $request->password,
                'scope' => '',
            ]);

            $response = app()->handle($tokenRequest);

            return ($user->is_active === 1 ?  $response : response(['message' => 'Inactive user', "token_type" => "licence_error"]));

        } else {

            return response(['message' => 'Password doesn\'t match', "token_type" => "error"]);

        }
    }

    public function getUserInfo() {
        return auth()->user();
    }

}
