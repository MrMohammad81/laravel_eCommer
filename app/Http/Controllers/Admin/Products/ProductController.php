<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\StoreRequest as CreateProductRequest;
use App\Http\Requests\Admin\products\UpdateCategoryRequest;
use App\Http\Requests\Admin\Products\UpdateRequest as UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use function alert;
use function redirect;
use function view;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $products = Product::latest()->paginate(15);

        return view('admin.products.index' , compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $brands = Brand::all();
        $tags = Tag::all();
        $categories = Category::where('parent_id' , '!=' , 0)->get();

        return view('admin.products.create' , compact('brands' , 'tags' , 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateProductRequest $request)
    {
        try
        {
            DB::beginTransaction();

            $request->validated();

            # upload images
            $fileNameImages = ProductImageController::upload($request->primary_image , $request->images);

            # store product
            $primaryImage = $fileNameImages['fileNamePrimaryImage'];

            $images = $fileNameImages['fileNameImage'];

            $product = $this->createProduct($request,$primaryImage);

            ProductImageController::createProductImages($product , $images);

            ProductAttributeController::store($request->attribute_ids , $product);

            $category = Category::find($request->category_id);
            $attributeID = $category->attributes()->wherePivot('is_variation' , 1)->first()->id;

            ProductVariationController::store($request->variation_values ,$attributeID , $product);

            $product->tags()->attach($request->tag_ids);

            DB::commit();

            Alert::success('ایجاد محصول' , "محصول $request->name با موفقیت ایجاد شد");
            return redirect()->route('admin.products.index');

        }catch (\Exception $exception)
        {
            DB::rollBack();
            alert()->error('خطا در ایجاد محصول' , $exception->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Product $product)
    {
        $productAttributes = $product->attributes()->with('attribute')->get();

        $productVariations = $product->variations;

        $images = $product->images;

        return view('admin.products.show' , compact('product' , 'productAttributes' , 'productVariations' , 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Product $product)
    {
        $productAttributes = $product->attributes()->with('attribute')->get();
        $productVariations = $product->variations;
        $brands = Brand::all();
        $tags = Tag::all();
        $ProductTagId = $product->tags()->pluck('id')->toArray();

        return view('admin.products.edit' , compact('product' , 'productAttributes' , 'productVariations' , 'brands' , 'tags' , 'ProductTagId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
       //dd($request->all());
        try
        {
            DB::beginTransaction();

            $request->validated();

            # update product
            $this->updateProduct($request,$product);

            ProductAttributeController::update($request->attribute_values);

            ProductVariationController::update($request->variation_values);

            $product->tags()->sync($request->tag_ids);

            DB::commit();

            Alert::success('بروزرسانی محصول' , "محصول $request->name با موفقیت بروزرسانی شد");
            return redirect()->route('admin.products.index');

        }catch (\Exception $exception)
        {
            DB::rollBack();
            alert()->error('خطا در بروزرسانی محصول' , $exception->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();

        Alert::success('حذف محصول', "محصول $product->name با موفقیت حذف شد");
        return redirect()->back();
    }

    private function createProduct($request , $imageName)
    {
        $product = Product::create([
            'name' => $request->name,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'primary_image' => $imageName,
            'description' => $request->description,
            'is_active' => $request->is_active,
            'delivery_amount' => $request->delivery_amount,
            'delivery_amount_per_product' => $request->delivery_amount_per_product,
        ]);
        return $product;
    }

    private function updateProduct($request , $product)
    {
         $product->update([
            'name' => $request->name,
            'brand_id' => $request->brand_id,
            'description' => $request->description,
            'is_active' => $request->is_active,
            'delivery_amount' => $request->delivery_amount,
            'delivery_amount_per_product' => $request->delivery_amount_per_product,
        ]);
    }

    # Edit category for product
    public function editCategory(Product $product)
    {
        $categories = Category::where('parent_id' , '!=' , 0)->get();

        return view('admin.products.edit_category' , compact('product' , 'categories'));
    }

    public function updateCategory(UpdateCategoryRequest $request , Product $product)
    {
        try
        {
            DB::beginTransaction();

            $request->validated();

            $product->update(['category_id' => $request->category_id]);

            ProductAttributeController::change($request->attribute_ids , $product);

            $category = Category::find($request->category_id);
            $attributeID = $category->attributes()->wherePivot('is_variation' , 1)->first()->id;

            ProductVariationController::change($request->variation_values ,$attributeID , $product);

            DB::commit();

            Alert::success('ایجاد محصول' , "محصول $request->name با موفقیت ایجاد شد");
            return redirect()->route('admin.products.index');

        }catch (\Exception $exception)
        {
            DB::rollBack();
            alert()->error('خطا در ایجاد محصول' , $exception->getMessage());
            return redirect()->back();
        }
    }


}
