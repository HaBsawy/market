<?php

namespace App\Http\Controllers;

use App\User;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
        $userSocial = Socialite::driver('facebook')->stateless()->user();
        $date = date('d-M-Y h:i:s');
        $mod_date = strtotime($date."+ 3600 seconds");
        $mod_date = date('d-M-Y h:i:s', $mod_date);

        if (User::where('email', $userSocial->email)->first()) {
            $token = auth()->attempt(['email' => $userSocial->email, 'password' => '123123']);
            return view('app', compact('token', 'mod_date'));
        } else {
            $user = new User();
            $user->name = $userSocial->name;
            $user->email = $userSocial->email;
            $user->password = bcrypt('123123');
            $user->role = 'customer';

            if ($user->save()) {
                $token = auth()->attempt(['email' => $userSocial->email, 'password' => '123123']);
                return view('app', compact('token', 'mod_date'));
            }
        }
    }

    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        $userSocial = Socialite::driver('google')->stateless()->user();
        $date = date('d-M-Y h:i:s');
        $mod_date = strtotime($date."+ 3600 seconds");
        $mod_date = date('d-M-Y h:i:s', $mod_date);

        if (User::where('email', $userSocial->email)->first()) {
            $token = auth()->attempt(['email' => $userSocial->email, 'password' => '123123']);
            return view('app', compact('token', 'mod_date'));
        } else {
            $user = new User();
            $user->name = $userSocial->name;
            $user->email = $userSocial->email;
            $user->password = bcrypt('123123');
            $user->role = 'customer';

            if ($user->save()) {
                $token = auth()->attempt(['email' => $userSocial->email, 'password' => '123123']);
                return view('app', compact('token', 'mod_date'));
            }
        }
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => [
                'username' => auth()->user()->name,
                'email' => auth()->user()->email,
                'role' => auth()->user()->role,
            ]
        ]);
    }
}
