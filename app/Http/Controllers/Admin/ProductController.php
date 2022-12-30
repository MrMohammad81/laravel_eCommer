<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Products\StoreRequest as CreateRequestProduct;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        try
        {
            DB::beginTransaction();
           // $request->validated();

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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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


}
