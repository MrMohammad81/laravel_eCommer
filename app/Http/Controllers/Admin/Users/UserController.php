<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Users\UpdateRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);

        return view('admin.users.index' , compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit' , compact('user'));
    }

    public function update(UpdateRequest $request , User $user)
    {
        $request->validated();

        $this->updateUser($request,$user);

        alert()->success('' , 'کاربر با موفقیت بروزرسانی شد')->showConfirmButton('تایید');
        return redirect()->route('admin.users.index');

    }

    private function updateUser($request , $user)
    {
        $user->update([
            'name' => $request->name,
            'cellphone' => $request->cellphone,
            'email' => $request->email,
        ]);
    }
}
