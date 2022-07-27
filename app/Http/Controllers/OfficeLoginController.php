<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class OfficeLoginController extends Controller {

    /////////////////////////////////////////////
    ///////////////Socialite API/////////////////
    /////////////////////////////////////////////
    public function redirectToProvider()
    {
        return Socialite::driver('azure')->redirect();
    }

    /////////////////////////////////////////////
    ///////////////Login The User////////////////
    /////////////////////////////////////////////
    public function handleProviderCallback()
    {

        $user = Socialite::driver('azure')->user();

        // create default roles

        if(! $authUser = User::whereEmail($user->getEmail())->first())
        {
            $authUser = new User;
            $unHash = $authUser->random_password(12);
            $username = $authUser->generateUsername();
            $password = Hash::make($unHash);
            $authUser->fill([
                'name' => $user->getName(),
                'username' => $username,
                'email' => $user->getEmail(),
                'password' => $password,
            ])->save();
        }

        auth()->login($authUser, false);
        /////////////////////////////////////////////
        ////////Return to the intended Url//////////
        /////////////////////////////////////////////
        if(session()->has('url.intended'))
        {
            return redirect(session('url.intended'));
        }

        return to_route('home');
    }

}
