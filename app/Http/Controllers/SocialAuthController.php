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
        $auth = $this->loginOrRegister($userSocial);
        $mod_date = $this->expiredAt(date('d-M-Y H:i:s'));
        return view('app', compact('auth', 'mod_date'));
    }

    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        $userSocial = Socialite::driver('google')->stateless()->user();
        $auth = $this->loginOrRegister($userSocial);
        $mod_date = $this->expiredAt(date('d-M-Y H:i:s'));
        return view('app', compact('auth', 'mod_date'));
    }

    private function loginOrRegister($mainUser)
    {
        if (User::where('email', $mainUser->email)->first()) {
            $token = auth()->attempt(['email' => $mainUser->email, 'password' => '123123']);
            return [
                'token' => $token,
                'username' => auth()->user()->name,
                'email' => auth()->user()->email,
                'role' => auth()->user()->role,
            ];
        } else {
            $user = new User();
            $user->name = $mainUser->name;
            $user->email = $mainUser->email;
            $user->password = bcrypt('123123');
            $user->role = 'customer';

            if ($user->save()) {
                $token = auth()->attempt(['email' => $mainUser->email, 'password' => '123123']);
                return [
                    'token' => $token,
                    'username' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'role' => auth()->user()->role,
                ];
            }
        }
    }

    private function expiredAt($time)
    {
        $mod_date = strtotime($time."+ 3600 seconds");
        $mod_date = date('d-M-Y H:i:s', $mod_date);
        return $mod_date;
    }
}
