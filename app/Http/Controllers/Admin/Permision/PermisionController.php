<?php

namespace App\Http\Controllers\Admin\Permision;

use App\Http\Controllers\Controller;
use App\Models\Permision;
use App\Http\Requests\Admin\Perimision\StoreRequest as StorePermisionRequest;
use App\Http\Requests\Admin\Perimision\UpdateRequest as UpdatePermisionRequest;
use RealRashid\SweetAlert\Facades\Alert;

class PermisionController extends Controller
{
    public function index()
    {
        $permissions = Permision::latest()->paginate(15);

        return view('admin.permissions.index' , compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(StorePermisionRequest $request)
    {
        $request->validated();

        $this->storePermision($request);

        alert()->success('' , "مجوز $request->name با موفقیت ایجاد شد")->showConfirmButton('تایید');
        return redirect()->route('admin.permissions.index');
    }

    public function edit(Permision $permision)
    {
        dd($permision);
        return view('admin.permissions.edit' , compact('permision'));
    }

    public function update(UpdatePermisionRequest $request , Permision $permision)
    {
        $request->validated();
    }

    public function destroy(Permision $permision)
    {
        dd($permision);
        $permision->delete();
        Alert::success('حذف مجوز', "مجوز $permision->display_name با موفقیت حذف شد");
        return redirect()->route('admin.permissions.index');
    }

    private function storePermision($request)
    {
        Permision::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'guard_name' => 'web',
        ]);
    }

}
