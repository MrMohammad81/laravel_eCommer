<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Dflydev\DotAccessData\Data;

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
}
