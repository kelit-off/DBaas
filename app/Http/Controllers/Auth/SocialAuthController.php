<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Socialite;

class SocialAuthController extends Controller
{
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(Request $request, string $provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();

        if (!$socialUser->getEmail()) {
            return redirect('/login')->withErrors(['email' => 'Email not provided by ' . $provider]);
        }

        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            if (!$user->provider) {
                $user->update([
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId()
                ]);

                Auth::login($user, true);

                return redirect("/app");
            }
        } else {
            $user = User::create([
                'name' => $socialUser->getName()
                    ?? $socialUser->getNickname()
                    ?? 'User',
                'email' => $socialUser->getEmail(),
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'password' => bcrypt(Str::random(32)),
            ]);

            Auth::login($user, true);

            return redirect("/dashboard/new");
        }
    }
}
