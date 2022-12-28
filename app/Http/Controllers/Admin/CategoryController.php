<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Admin\Categories\CreateRequest as CreateCategoryRequest;
use App\Http\Requests\Admin\Categories\UpdateRequest as UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $categories = Category::latest()->paginate(15);

        return view('admin.categories.index' , compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $parentCategories = Category::where('parent_id' , 0)->get();
        $attributes = Attribute::all();

        return view('admin.categories.create' , compact('parentCategories' , 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCategoryRequest $request)
    {
        try {
            DB::beginTransaction();

            $request->validated();

            $category = $this->createCategory($request);

            $this->setAttributes($request, $category);

            DB::commit();
        }catch (\Exception $exception)
        {
            DB::rollBack();
            \alert()->error('خطا در ایجاد دسته بندی' , $exception->getMessage())->persistent('ok');
            return redirect()->back();
        }
        Alert::success('ایجاد دسته بندی' , "دسته بندی $category->name با موفقیت ایجاد شد");
        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Category $category)
    {
        return view('admin.categories.show' , compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::where('parent_id' , 0)->get();
        $attributes = Attribute::all();

        return view('admin.categories.edit' , compact('category' , 'attributes' , 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            DB::beginTransaction();

            $request->validated();

            $this->updateCategory($request , $category);

            $this->updateAttributes($request, $category);

            DB::commit();
        }catch (\Exception $exception)
        {
            DB::rollBack();
            \alert()->error('خطا در بروزرسانی دسته بندی' , $exception->getMessage())->persistent('ok');
            return redirect()->back();
        }
        Alert::success('بروزرسانی دسته بندی' , "دسته بندی $category->name با موفقیت بروزرسانی شد");
        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        $category->delete();
        Alert::success('حذف ویژگی', "دسته بندی $category->name با موفقیت حذف شد");
        return redirect()->route('admin.categories.index');
    }

    private function createCategory($request)
    {
        $category =  Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'parent_id' => $request->parent_id,
            'is_active' => $request->is_active,
            'icon' => $request->icon,
            'description' => $request->description,
        ]);
      return $category;
    }

    private function setAttributes($request , $category)
    {
        foreach ($request->attribute_ids as $attribute_id)
        {
            $attribute = Attribute::findOrFail($attribute_id);
            $attribute->categories()->attach($category->id , [
                'is_filter' => in_array($attribute_id , $request->attribute_is_filter_ids) ? 1 : 0,
                'is_variation' => $request->variation_id == $attribute_id ? 1 : 0
            ]);
        }
    }

    private function updateCategory($request , $category)
    {
          $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'parent_id' => $request->parent_id,
            'is_active' => $request->is_active,
            'icon' => $request->icon,
            'description' => $request->description,
        ]);
    }

    private function updateAttributes($request , $category)
    {
        $category->attributes()->detach();

        foreach ($request->attribute_ids as $attributeId)
        {
            $attribute = Attribute::findOrFail($attributeId);
            $attribute->categories()->attach($category->id, [
                'is_filter' => in_array($attributeId, $request->attribute_is_filter_ids) ? 1 : 0,
                'is_variation' => $request->variation_id == $attributeId ? 1 : 0
            ]);
        }
    }
}
