<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Http\Requests\Admin\Attributes\StoreRequest;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Admin\Attributes\UpdateRequest;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $attributes = Attribute::paginate(15);
        return view('admin.attributes.index' , compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $request->validated();

        $createBrand = Attribute::create([
            'name' => $request->name,
        ]);

        Alert::success('ایجاد ویژگی', " ویژگی $request->name با موفقیت ثبت شد ");
        return redirect()->route('admin.attributes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Attribute $attribute)
    {
        return view('admin.attributes.show' , compact('attribute'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Attribute $attribute)
    {
        return view('admin.attributes.edit' , compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, Attribute $attribute)
    {
        $request->validated();

        $updatedData = $attribute->update([
            'name' => $request->name,
        ]);
        Alert::success('بروزرسانی ویژگی' , "ویژگی $request->name با موفقیت بروزرسانی شد");
        return redirect()->route('admin.attributes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {

         $deleteBrand = $attribute->delete();
         Alert::success('حذف ویژگی', "ویژگی $attribute->name با موفقیت حذف شد");
         return redirect()->route('admin.attributes.index');
    }
}
