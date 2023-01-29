<?php

namespace App\Http\Controllers\Admin\Attributes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Attributes\StoreRequest as CreateAttributeRequest;
use App\Http\Requests\Admin\Attributes\UpdateRequest as UpdateAttributeRequest;
use App\Models\Attribute;
use RealRashid\SweetAlert\Facades\Alert;
use function redirect;
use function view;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $attributes = Attribute::latest()->paginate(15);
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
    public function store(CreateAttributeRequest $request)
    {
        $request->validated();

        $this->createAttribute($request);

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
    public function update(UpdateAttributeRequest $request, Attribute $attribute)
    {
        $request->validated();

        $this->updateAttribute($request , $attribute);

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
         $attribute->delete();
         Alert::success('حذف ویژگی', "ویژگی $attribute->name با موفقیت حذف شد");
         return redirect()->route('admin.attributes.index');
    }

    private function createAttribute($request)
    {
         Attribute::create([
            'name' => $request->name,
        ]);
    }

    private function updateAttribute($request , $attribute)
    {
         $attribute->update([
            'name' => $request->name,
        ]);
    }
}
