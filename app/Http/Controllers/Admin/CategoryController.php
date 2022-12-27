<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Http\Request;
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
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        dd($request->all());
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
}
