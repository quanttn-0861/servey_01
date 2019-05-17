<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Requests\RegisterRequest;
use App\Repositories\User\UserRepository;
use App\Mail\Register;
use Carbon\Carbon;
use DB;
use Exception;
use Mail;
use Session;

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
            'image' => config('setting.image_user_default'),
            'gender' => null,
            'confirmation_code' => time().uniqid(true),
        ];
        $user = $this->userRepository->firstOrCreate($input);
        if ($user) {
            Mail::to($input['email'])->queue((new Register($input))->onConnection('database'));

            return response()->json(config('users.register_success'));
        }

        return response()->json(config('users.register_fail'));
    }

    public function confirmCode($code)
    {
        $user = $this->userRepository->where('confirmation_code', $code)->first();

        if ($user) {
            DB::beginTransaction();
            try {
                $updateUser = [
                    'status' => config('users.status.active'),
                    'confirmation_code' => null,
                ];
                $this->userRepository->update($user->id, $updateUser);
                DB::commit();
                Auth::login($user);

                return redirect()->route('home');
            } catch (Exception $e) {
                DB::rollback();
            }
        } else {
            Session::flash('confirmation-failed', trans('auth.confirmation_failed'));

            return redirect()->route('home');
        }
    }
}
