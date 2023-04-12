<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Permision;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\Admin\Users\UpdateRequest;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);

        return view('admin.users.index' , compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        $permissions = Permision::all();
        return view('admin.users.edit' , compact('user' , 'roles' , 'permissions'));
    }

    public function update(UpdateRequest $request , User $user)
    {
        try {
            DB::beginTransaction();

            $request->validated();

            $this->updateUser($request, $user);

            $user->syncRoles($request->role);

            $permissions = $request->except('_token', 'name', 'cellphone', '_method','role','email');
            $user->syncPermissions($permissions);

            DB::commit();

            alert()->success('', 'کاربر با موفقیت بروزرسانی شد')->showConfirmButton('تایید');
            return redirect()->route('admin.users.index');
        }catch (\Exception $exception)
        {
            DB::rollBack();
            alert()->error('خطا در بروزرسانی کاربر' , $exception->getMessage());
            return redirect()->back();
        }

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
