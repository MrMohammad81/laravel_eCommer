<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory , Sluggable , SoftDeletes;

    protected $guarded = [];
    protected $table = 'products';
    protected $appends = ['quantity_check'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getIsActiveAttribute($is_active)
    {
        return $is_active ? 'فعال' : 'غیرفعال' ;
    }



    public function tags()
    {
        return $this->belongsToMany(Tag::class , 'product_tag');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function rates()
    {
        return $this->hasMany(ProductRate::class);
    }

    public function QuantityCheckeProduct()
    {
        return $this->variations()->where('quantity' , '>' , 0)->first() ?? 0;
    }

    public function MinPriceCheckeProduct()
    {
        return $this->variations()->where('quantity' , '>' , 0)->orderBy('price')->first() ?? 0;
    }

    public function SaleCheckeProduct()
    {
        return $this->variations()->where('quantity' , '>' , 0)
            ->where('sale_price' , '!=' , null)
            ->where('date_on_sale_from' , '<=' , Carbon::now())
            ->where('date_on_sale_to' , '>=' , Carbon::now())
            ->orderBy('sale_price')->first() ?? false;
    }

    public function scopeFilter($query)
    {
        # Attributes Filter
        if (request()->has('attribute'))
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

        # Variations Filter
        if (request()->has('variation'))
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

        # SortBy Filter
        if (request()->has('sortBy'))
        {
            $sortBy = request()->sortBy;

            switch ($sortBy)
            {
                case 'max':
                    $query->orderByDesc(
                        ProductVariation::select('price')
                        ->whereColumn('product_variations.product_id' , 'products.id')
                        ->orderBy('sale_price' , 'desc')
                        ->take(1)
                    );
                    break;

                case 'min':
                    $query->orderBy(
                        ProductVariation::select('price')
                            ->whereColumn('product_variations.product_id' , 'products.id')
                            ->orderBy('sale_price' , 'asc')
                            ->take(1)
                    );
                    break;

                case 'latest':
                    $query->latest();
                    break;

                case 'oldest':
                    $query->oldest();
                    break;

                default :
                    return $query;
            }
        }
//        dd($query->toSql());
        return $query;
    }

    public function scopeSearch($query)
    {
        $keyWord = request()->search;

        if (!request()->has('search'))
            return $query;

        $query->where('name' , 'LIKE' , '%' . trim($keyWord) . '%');
    }
}
