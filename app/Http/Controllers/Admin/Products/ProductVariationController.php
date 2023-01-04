<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Models\ProductVariation;
use function convertShamsiDateToGregorian;

class ProductVariationController extends Controller
{
    public static function store($variations , $attributeId , $product)
    {
        $counter = count($variations['value']);

        for ($i = 0 ; $i < $counter ; $i++)
        {
            ProductVariation::create([
                'attribute_id' => $attributeId,
                'product_id' => $product->id,
                'value' => $variations['value'][$i],
                'price' => $variations['price'][$i],
                'quantity' => $variations['quantity'][$i],
                'sku' => $variations['sku'][$i],
            ]);
        }
    }

    public static function update($variationIds)
    {
       // dd($variationIds);
        foreach ($variationIds as $key => $value)
        {
            $productVariation = ProductVariation::findorFail($key);

            $productVariation->update([
                'price' => $value['price'],
                'quantity' => $value['quantity'],
                'sku' => $value['sku'],
                'sale_price' => $value['sale_price'],
                'date_on_sale_from' => convertShamsiDateToGregorian($value['date_on_sale_from']),
                'date_on_sale_to' => convertShamsiDateToGregorian($value['date_on_sale_to']),
            ]);
        }
    }

    public static function change($variations , $attributeId , $product)
    {
        ProductVariation::where('product_id' , $product->id)->delete();

        $counter = count($variations['value']);

        for ($i = 0 ; $i < $counter ; $i++)
        {
            ProductVariation::create([
                'attribute_id' => $attributeId,
                'product_id' => $product->id,
                'value' => $variations['value'][$i],
                'price' => $variations['price'][$i],
                'quantity' => $variations['quantity'][$i],
                'sku' => $variations['sku'][$i],
            ]);
        }
    }
}
