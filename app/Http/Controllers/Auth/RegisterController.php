<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Requests\RegisterRequest;
use App\Repositories\User\UserRepository;
use Carbon\Carbon;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->only([
            'name',
            'email',
            'password',
        ]);

        $input = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'level' => config('users.level.user'),
            'status' => config('users.status.active'),
            'image' => config('setting.image_user_default'),
            'gender' => null,
        ];
        $user = $this->userRepository->firstOrCreate($input);

        if ($user) {
            Auth::login($user);

            return response()->json(config('users.register_success'));
        }

        return response()->json(config('users.register_fail'));
    }
}
