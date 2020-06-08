<?php

namespace App\Http\Controllers;

use App\User;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function callback($driver)
    {
        $userSocial = Socialite::driver($driver)->stateless()->user();
        $auth = $this->loginOrRegister($userSocial);
        $mod_date = $this->expiredAt(date('d-M-Y H:i:s'));
        $subquery = 'token=' . $auth['token'] . '&username=' . $auth['username'] . '&email=' . $auth['email'] . '&role=' . $auth['role'] . '&date=' . $mod_date;
        return redirect()->to('https://market94.netlify.app/?' . $subquery);
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
