<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\AddImageRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Http\Requests\Admin\Products\EditImagesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ProductImageController extends Controller
{
    public static function upload($primaryImage , $images)
    {
        $fileNameImagePrimary = generatiFileNameWithDate($primaryImage->getClientOriginalName());

        $primaryImage->move(env('PRODUCT_IMAGES_UPLOAD_PATCH'), $fileNameImagePrimary);

        $fileNameImages = [];
        foreach ( $images as $image)
        {
            $fileNameImage = generatiFileNameWithDate($image->getClientOriginalName());

            $image->move(env('PRODUCT_IMAGES_UPLOAD_PATCH'), $fileNameImage);

            $fileNameImages[] = $fileNameImage;
        }

        return ['fileNamePrimaryImage' => $fileNameImagePrimary , 'fileNameImage' => $fileNameImages];
    }

    public static function createProductImages($product , $imageName)
    {
        foreach ($imageName as $fileNameImage)
        {
            ProductImage::create([
                'product_id' => $product->id,
                'images' => $fileNameImage
            ]);
        }
    }

    public static function edit(Product $product)
    {
        return view('admin.products.edit_images' , compact('product'));
    }

    public static function destroy(EditImagesRequest $request)
    {
        $request->validated();

        ProductImage::destroy($request->image_id);

        Alert::success('حذف تصویر' , 'تصویر مورد نظر با موفقیت حذف شد.');
        return redirect()->back();
    }

    # select image in product_images  for primary_image
    public function setPrimary(EditImagesRequest $request , Product $product)
    {
        $request->validated();

        $productImage = ProductImage::findOrFail($request->image_id);

        $this->updatePrimaryImageInProduct($productImage->images , $product);

        Alert::success('بروزرسانی تصویر اصلی' , 'تصویر مورد نظر با موفقیت به عنوان تصویر اصلی ثبت شد.');
        return redirect()->back();
    }

    public function add(AddImageRequest $request , Product $product)
    {
        try {
            DB::beginTransaction();

            $request->validated();

            $primaryImage = $request->primary_image;

            $images = $request->images;

            if ($primaryImage == null && $images == null)
            {
                return redirect()->back()->withErrors(['msg' => 'تصویر اصلی یا تصاویر محصول الزامی است']);
            }

            if ($request->has('primary_image'))
            {
                $this->updatePrimaryImage($primaryImage , $product);
            }

            if ($request->has('images'))
            {
                $this->updateImages($images, $product);
            }

            DB::commit();
            Alert::success('بروزرسانی تصویر اصلی', 'تصویر مورد نظر با موفقیت به عنوان تصویر اصلی ثبت شد.');
            return redirect()->back();

        }catch (\Exception $exception)
        {
            DB::rollBack();
            alert()->error('خطا در بروزرسانی تصویر محصول' , $exception->getMessage());
            return redirect()->back();
        }
    }


    # update primary_image name in product table
    private function updatePrimaryImageInProduct($imageName , $product)
    {
        $product->update([
            'primary_image' => $imageName
        ]);
    }


    # product primary_image
    private function updatePrimaryImage($primaryImage , $product)
    {
        $fileNameImagePrimary = generatiFileNameWithDate($primaryImage->getClientOriginalName());

        $primaryImage->move(public_path( env('PRODUCT_IMAGES_UPLOAD_PATCH')), $fileNameImagePrimary);

        $this->updatePrimaryImageInProduct($fileNameImagePrimary , $product);

        return $this;
    }


    # product images
    private function updateImages($images , $product)
    {
        foreach ( $images as $image)
        {
            $fileNameImage = generatiFileNameWithDate($image->getClientOriginalName());

            $image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATCH')), $fileNameImage);

            ProductImage::create([
               'product_id' => $product->id,
               'images' => $fileNameImage
            ]);
        }
    }
}
