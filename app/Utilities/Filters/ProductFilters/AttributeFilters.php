<?php

namespace App\Utilities\Filters\ProductFilters;

class AttributeFilters
{
    public static function applyAttributeFilter($query)
    {
        foreach (request()->attribute as $attribute)
        {
            $query->whereHas('attributes' , function ($query) use ($attribute)
            {
                foreach ( explode('-' , $attribute) as $index => $item)
                {
                    if ($index == 0)
                    {
                        $query->where('value' , $item);
                    }else {
                        $query->orWhere('value' , $item);
                    }
                }
            });
        }
    }
}
