<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    public static function store( $attributes , $product)
    {
        foreach ($attributes as $key => $value)
        {
            ProductAttribute::create([
               'attribute_id' => $key,
                'product_id' => $product->id,
                'value' => $value
            ]);
        }
    }

    public static function update($attributeIds)
    {
        foreach ($attributeIds as $key => $value)
        {
            $productAttribute = ProductAttribute::findOrFail($key);

            $productAttribute->update([
                'value' => $value
            ]);
        }
    }

    public static function change($attributes , $product)
    {
        ProductAttribute::where('product_id' , $product->id)->delete();

        foreach ($attributes as $key => $value)
        {
            ProductAttribute::create([
                'attribute_id' => $key,
                'product_id' => $product->id,
                'value' => $value
            ]);
        }
    }
}
