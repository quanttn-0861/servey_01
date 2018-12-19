<?php

namespace App\Http\Controllers\Survey;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserInterface;
use Auth;
use Carbon\Carbon;
use Session;
use Hash;
use Exception;
use App\Http\Requests\Survey\ChangePassWordRequest;
use App\Http\Requests\Survey\ProfileRequest;
use File;
use Storage;

class ProfileController extends Controller
{
    protected $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user = Auth::user();
            Session::put('page_profile_active', config('settings.page_profile_active.information'));

            return view('clients.profile.index', compact('user'));
        } catch (Exception $e) {
            return view('clients.layout.404');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = $this->userRepository->find($id);

            return view('clients.profile.index', compact('user'));
        } catch (Exception $e) {
            return view('clients.layout.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $user = $this->userRepository->find($id);
            $this->authorize('update', $user);

            return view('clients.profile.setting', compact('user'));
        } catch (Exception $e) {
            return view('clients.layout.404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request, $id)
    {
        try {
            $user = $this->userRepository->find($id);
            $this->authorize('update', $user);
            $updateData = $request->only([
                'name',
                'phone',
                'gender',
                'address',
            ]);
            $birthday = $request->birthday;

            if (Session::get('locale') == config('settings.vn')) {
                $birthday = str_replace('/', '-', $birthday);
            }

            $updateData['birthday'] = Carbon::parse($birthday)->toDateString();

            $this->userRepository->update($id, $updateData);

            return redirect()->route('survey.profile.show', $id)->with('success', trans('profile.edit_success'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', trans('profile.edit_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showChangePassword()
    {
        try {
            $user = Auth::user();

            return view('clients.profile.changepassword', compact('user'));
        } catch (Exception $e) {
            return view('clients.layout.404');
        }
    }

    public function changePassword(ChangePassWordRequest $request)
    {
        try {
            $user = Auth::user();

            if (!Hash::check($request->oldpassword, $user->password)) {
                $error = trans('profile.password_wrong');
                throw new Exception('Old password wrong');
            }

            if ($request->newpassword != $request->retypepassword) {
                $error = trans('profile.password_confirm_wrong');
                throw new Exception('Password confirm wrong!');
            }

            $updateData['password'] = $request->newpassword;
            $this->userRepository->updateUser($user, $updateData);
            Session::flash('success', trans('profile.edit_success'));
        } catch (Exception $e) {
            if (!isset($error)) {
                $error = trans('profile.edit_error');
            }

            Session::flash('error', $error);
        }

        return redirect()->back();
    }

    public function changeAvatar(Request $request)
    {
        try {
            $user = Auth::user();
            $updateData['image'] = $this->userRepository->uploadAvatar(
                $request,
                'image',
                $user->image,
                config('settings.path_upload_avatar')
            );
            $this->userRepository->updateUser($user, $updateData);

            return redirect()->back()->with('success', trans('profile.edit_success'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', trans('profile.edit_error'));
        }
    }

    public function deleteAvatar()
    {
        try {
            $user = Auth::user();

            if (Storage::disk('local')->exists($user->image) && $user->image != config('settings.image_user_default')) {
                Storage::disk('local')->delete($user->image);
            }

            $user = $this->userRepository->updateUser($user, ['image' => '']);

            return redirect()->back()->with('success', trans('profile.edit_success'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', trans('profile.edit_error'));
        }
    }

    public function setBackground(Request $request)
    {
        try {
            if ($request->background_cover) {
                $user = Auth::user();
                $updateData['background'] = $request->background_cover;
                $this->userRepository->updateUser($user, $updateData);
                Session::flash('success', trans('profile.edit_success'));
            } else {
                Session::flash('error', trans('profile.image_not_found'));
            }
        } catch (Exception $e) {
            Session::flash('error', trans('profile.edit_error'));
        }

        return redirect()->back();
    }
}
