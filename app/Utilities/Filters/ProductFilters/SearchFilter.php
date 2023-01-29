<?php

namespace App\Utilities\Filters\ProductFilters;

class SearchFilter
{
    public static function scopeSearch($query)
    {
        $keyWord = request()->search;

        if (!request()->has('search'))
            return $query;

        $query->where('name' , 'LIKE' , '%' . trim($keyWord) . '%');
    }
}
