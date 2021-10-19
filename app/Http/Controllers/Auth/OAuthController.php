<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\IdentityProvider;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OAuthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    public function oauthCallback()
    {
        try {
            $socialUser = Socialite::with('github')->user();
        } catch (\Throwable $th) {
            return redirect('/login')->withErrors([
                'oauth' => '予期せぬエラーが発生しました'
            ]);
        }

        $user = User::firstOrNew(['email' => $socialUser->getEmail()]);
        if(!$user->exists){
            $user->name = $socialUser->getNickname() ?? $socialUser->name;
            $identityProvider = new IdentityProvider([
                'id' => $socialUser->getId(),
                'name' => 'github'
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
        }
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
