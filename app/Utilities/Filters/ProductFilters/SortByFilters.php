<?php

namespace App\Utilities\Filters\ProductFilters;

use App\Models\ProductVariation;

class SortByFilters
{
    public static function sortByMax($query)
    {
        $query->orderByDesc(
            ProductVariation::select('price')
                ->whereColumn('product_variations.product_id' , 'products.id')
                ->orderBy('sale_price' , 'desc')
                ->take(1)
        );
    }

    public static function sortByMin($query)
    {
        $query->orderBy(
            ProductVariation::select('price')
                ->whereColumn('product_variations.product_id' , 'products.id')
                ->orderBy('sale_price' , 'asc')
                ->take(1)
        );
    }

    public static function sortByLatest($query)
    {
        $query->latest();
    }

    public static function sortByOldest($query)
    {
        $query->oldest();
    }

}
