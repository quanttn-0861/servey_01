<?php

namespace App\Repositories\Socialite;

use Laravel\Socialite\Contracts\User as ProviderUser;
use App\Models\SocialAccount;
use App\Repositories\User\UserInterface;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use App\Models\User;

class SocialAccountRepository extends BaseRepository
{
    public function getModel()
    {
        return SocialAccount::class;
    }

    public function createOrGetUser($providerUser, $provider)
    {
        $account = $provider == config('settings.framgia')
            ? $this->where('provider', $provider)->where('email', $providerUser->email)->first()
            : $this->where('provider', $provider)->where('provider_user_id', $providerUser->getId())->first();
        $user = null;

        if ($account) {
            $user = app(UserInterface::class)->find($account->user_id);
            $data = [
                'email' => $providerUser->email,
                'name' => $providerUser->name,
                'image' => $providerUser->avatar,
            ];

            if ($provider == config('settings.framgia')) {
                $data['birthday'] = $providerUser->birthday;
                $data['phone'] = $providerUser->phone_number;

                if ($providerUser->gender == 'male') {
                    $data['gender'] = config('users.gender.male');
                } elseif ($providerUser->gender == 'female') {
                    $data['gender'] = config('users.gender.female');
                } else {
                    $data['gender'] = config('users.gender.other_gender');
                }
            }

            if ($providerUser->email) {
                app(UserInterface::class)->newQuery(new User());
                $check = app(UserInterface::class)
                    ->where('email', $providerUser->email)
                    ->where('id', '<>', $user->id)
                    ->exists();
                $data = $check ? array_except($data, ['email']) : $data;
            }

            $account->fill($data);

            if ($account->getDirty()) {
                $account->save();
                $user->fill($data);
                $user->save();
            }

            return $user;
        }

        if ($providerUser->email) {
            $user = app(UserInterface::class)->where('email', $providerUser->email)->first();
        }

        if (!$user) {
            $newUser = [
                'email' => $providerUser->email,
                'name' => $providerUser->name,
                'password' => '',
                'image' => $providerUser->avatar,
                'level' => config('users.level.user'),
                'status' => config('users.status.active'),
            ];

            if ($provider == config('settings.framgia')) {
                $newUser['birthday'] = Carbon::parse($providerUser->birthday)->toDateString();
                $newUser['phone'] = $providerUser->phone_number;

                if ($providerUser->gender == 'male') {
                    $newUser['gender'] = config('users.gender.male');
                } elseif ($providerUser->gender == 'female') {
                    $newUser['gender'] = config('users.gender.female');
                } else {
                    $newUser['gender'] = config('users.gender.other_gender');
                }
            }

            $user = app(UserInterface::class)->firstOrCreate($newUser);
        }

        $account = $this->create([
            'user_id' => $user->id,
            'provider_user_id' => $provider == config('settings.framgia') ? $providerUser->user['id'] : $providerUser->id,
            'provider' => $provider,
            'email' => $providerUser->email,
            'name' => $providerUser->name,
            'image' => $providerUser->avatar,
        ]);

        return $user;
    }
}
