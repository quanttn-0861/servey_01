<?php

namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Socialite\SocialAccountRepository;
use Socialite;
use Auth;
use FAuth;
use Exception;
use Session;
use URL;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        Session::put('backUrl', URL::previous());

        return $provider == config('settings.framgia') ? FAuth::driver($provider)->redirect() : Socialite::driver($provider)->redirect();
    }

    public function callback(SocialAccountRepository $service, $provider)
    {
        $driver = $provider == config('settings.framgia') ? FAuth::driver($provider) : Socialite::driver($provider);

        try {
            $user = $service->createOrGetUser($driver->user(), $provider);

            if ($user->isActive()) {
                auth()->login($user);

                if (Session::has('backUrl')) {
                    $url = Session::get('backUrl');
                    Session::forget('backUrl');

                    return redirect()->intended($url);
                }

                return redirect()->intended(action('SurveyController@index'));
            }
        } catch (Exception $e) {
            return redirect()->action('SurveyController@index')
                ->with('message-fail', trans('messages.login_social_error', ['object' => $provider]));
        }

        return redirect()->action('Auth\LoginController@getLogin')
            ->with('message', trans('messages.block'));
    }
}
