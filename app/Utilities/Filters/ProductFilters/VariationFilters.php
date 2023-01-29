<?php

namespace App\Utilities\Filters\ProductFilters;

class VariationFilters
{
    public static function applyVariationFilter($query)
    {
        $query->whereHas('variations' , function ($query)
        {
            foreach ( explode('-' , request()->variation) as $index => $variation)
            {
                if ($index == 0)
                {
                    $query->where('value' , $variation);
                }else {
                    $query->orWhere('value' , $variation);
                }
            }
        });
    }
}
