<?php

namespace App\Models;

use App\Utilities\Filters\ProductFilters\AttributeFilters;
use App\Utilities\Filters\ProductFilters\SearchFilter;
use App\Utilities\Filters\ProductFilters\SortByFilters;
use App\Utilities\Filters\ProductFilters\VariationFilters;
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

    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->where('approved' , 1);
    }

    public function checkUserWishlist($userId)
    {
        return $this->hasMany(Wishlist::class)->where('user_id' , $userId)->exists();
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
           AttributeFilters::applyAttributeFilter($query);
        }

        # Variations Filter
        if (request()->has('variation'))
        {
            VariationFilters::applyVariationFilter($query);
        }

        # SortBy Filter
        if (request()->has('sortBy'))
        {
            $sortBy = request()->sortBy;

            switch ($sortBy)
            {
                case 'max':
                    SortByFilters::sortByMax($query);
                    break;

                case 'min':
                   SortByFilters::sortByMin($query);
                    break;

                case 'latest':
                    SortByFilters::sortByLatest($query);
                    break;

                case 'oldest':
                   SortByFilters::sortByOldest($query);
                    break;

                default :
                    return $query;
            }
        }
        return $query;
    }

    public function scopeSearch($query)
    {
        SearchFilter::scopeSearch($query);
    }
}
