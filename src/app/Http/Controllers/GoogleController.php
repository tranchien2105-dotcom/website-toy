<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {

            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {

                $user = User::create([

                    'name' => $googleUser->getName(),

                    'email' => $googleUser->getEmail(),

                    'google_id' => $googleUser->getId(),

                    'avatar' => $googleUser->getAvatar(),

                    'password' => bcrypt(Str::random(32)),

                ]);

            } else {

                $user->update([

                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),

                ]);

            }

            Auth::login($user, true);

            return redirect()->intended('/');

        } catch (\Exception $e) {   
            return redirect('/layout-login')->with('error', $e->getMessage());

        }
    }
}