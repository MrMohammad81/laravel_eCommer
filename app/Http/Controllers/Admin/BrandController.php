<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
Use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Admin\Brands\StoreRequest;
use App\Http\Requests\Admin\brands\UpdateRequest;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $brands = Brand::paginate(20);
        return view('admin.brands.index' , compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.brands.create');
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

        $createBrand = Brand::create([
            'name' => $request->name,
            'is_active' => $request->is_active
        ]);

         Alert::success('ایجاد برند', "برند $request->name با موفقیت ثبت شد");
        return redirect()->route('admin.brands.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Brand $brand)
    {
        return view('admin.brands.show' , compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit' , compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, Brand $brand)
    {
        $request->validated();

        $updatedData = $brand->update([
           'name' => $request->name,
            'is_active' => $request->is_active
        ]);
        Alert::success('بروزرسانی برند' , "برند $request->name با موفقیت بروزرسانی شد");
        return redirect()->route('admin.brands.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Brand $brand)
    {
         $deleteBrand = $brand->delete();
         Alert::success('حذف برند', "برند $brand->name با موفقیت حذف شد");
         return redirect()->route('admin.brands.index');
    }
}
