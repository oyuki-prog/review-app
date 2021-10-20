<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\IdentityProvider;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function oauthCallBack($provider)
    {
        try {
            $socialUser = Socialite::with($provider)->user();
        } catch (\Throwable $th) {
            return redirect('/login')->withErrors(['oauth' => 'ユーザー情報を読み込めませんでした']);
        }

        $user = User::firstOrNew(['email' => $socialUser->getEmail()]);
        $identityProvider = IdentityProvider::firstOrNew([
            'id' => $socialUser->getId(),
            'provider' => $provider
        ]);

        if (!$user->exists) {
            $user->name = $socialUser->name ?? $socialUser->getNickname();
            $user->email = $socialUser->getEmail();
            $identityProvider = new IdentityProvider([
                'id' => $socialUser->getId(),
                'provider' => $provider
            ]);

            DB::beginTransaction();
            try {
                $user->save();
                $user->identityProvider()->save($identityProvider);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()
                    ->route('login')
                    ->withErrors(['transaction_error' => '保存に失敗しました']);
            }
        } elseif (!$identityProvider->exists) {
            $user->identityProvider()->save($identityProvider);
        }

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
