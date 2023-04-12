<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Requests\Admin\Roles\StoreRequest as StoreRoleRequest;
use App\Http\Requests\Admin\Roles\UpdateRequest as UpdateRoleRequest;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::latest()->paginate(15);

        return view('admin.roles.index' , compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();

        return view('admin.roles.create' , compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        try {
            DB::beginTransaction();

            $request->validated();

            $role = $this->createRole($request);

            $permision = $request->except('_token', 'display_name', 'name');
            $role->givePermissionTo($permision);

            DB::commit();

            alert()->success('', "نقش $request->name با موفقیت ایجاد شد")->showConfirmButton('تایید');
            return redirect()->route('admin.roles.index');
        }catch (\Exception $exception)
        {
            DB::rollBack();
            alert()->error('خطا در ایجاد نقش' , $exception->getMessage());
            return redirect()->back();
        }
    }

    public function show(Role $role)
    {
        return view('admin.roles.show' , compact('role'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();

        return view('admin.roles.edit' , compact('role' , 'permissions'));
    }

    public function update(UpdateRoleRequest $request , Role $role)
    {
        try {
            DB::beginTransaction();

            $request->validated();

            $this->updateRole($request, $role);

            $permissions = $request->except('_token', 'name', 'display_name', '_method');

            $role->syncPermissions($permissions);

            DB::commit();

            alert()->success('', "نقش $request->name با موفقیت بروزرسانی شد")->showConfirmButton('تایید');
            return redirect()->route('admin.roles.index');

        }catch (\Exception $exception)
        {
            DB::rollBack();
            alert()->error('خطا در بروزرسانی نقش' , $exception->getMessage());
            return redirect()->back();
        }
    }

    private function createRole($request)
    {
       $createdData = Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'guard_name' => 'web',
        ]);
       return $createdData;
    }

    private function updateRole($request , $role)
    {
        $updatedData = $role->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'guard_name' => 'web',
        ]);
        return $updatedData;
    }
}
