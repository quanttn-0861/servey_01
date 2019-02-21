<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\User\UserRepository;
use Auth;
use Session;
use Carbon\Carbon;

class UserManagementController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->getUser();
        $user = Auth::user();

        return view('clients.user.index', compact('users', 'user'));
    }

    public function edit($id)
    {
        try {
            $user = $this->userRepository->find($id);

            return view('clients.user.edit', compact('user'));
        } catch (Exception $e) {
            return view('clients.layout.404');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = $this->userRepository->find($id);
            $updateData = $request->only([
                'name',
                'phone',
                'gender',
                'address',
            ]);
            $birthday = Carbon::createFromFormat(trans('lang.date_format'), $request->birthday);
            $updateData['birthday'] = Carbon::parse($birthday)->toDateString();
            $this->userRepository->update($id, $updateData);

            return redirect()->route('management-user.index')->with('success', trans('profile.edit_success'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', trans('profile.edit_error'));
        }
    }

    public function destroy($id)
    {
        try {
            $user = $this->userRepository->findOrFail($id);
            $user->delete();
            Session::flash('success', trans('lang.delete_user_success'));
        } catch (Exception $e) {
            Session::flash('error', trans('lang.delete_user_error'));
        }

        return redirect()->back();
    }

    public function getListUser(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        } else {
            $data = $request->only('name');
            $users = $this->userRepository->getUser($data);
            $html = view('clients.user.list_user', compact('users'))->render();
        }

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    public function showHtml($id)
    {
        $user = $this->userRepository->findOrFail($id);

        return $user['status'] == config('users.status.active') ?
            "<button class='btn btn-info status-user' id = $user->id value = $user->status>$user->status_custom</button>" :
            "<button class='btn btn-danger status-user' id = $user->id value = $user->status>$user->status_custom</button>";
    }

    public function changeStatus(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        try {
            $status = $request->status;
            $id = $request->id;
            $status == config('users.status.block') ?
                $this->userRepository->changeStatus($id, config('users.status.active')) :
                $this->userRepository->changeStatus($id, config('users.status.block'));
            $html = $this->showHtml($id);
        } catch (Exception $e) {
            Session::flash('error', trans('lang.edit_status_user_error'));
        }

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }
}
