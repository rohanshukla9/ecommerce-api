<?php

namespace App\Models;

use App\Cart\Money;
use App\Models\Collections\ProductVariationCollection;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVariationType;
use App\Models\Traits\HasPrice;

class ProductVariation extends Model
{
    //
    use HasPrice;

    public function getPriceAttribute($value)
    {
        if ($value === null) {
            return $this->product->price;
        }
        return new Money($value);
    }

    public function minStock($count)
    {
        return min($this->stockCount(), $count); //200
    }


    public function priceVaries()
    {
        return $this->price->amount() !== $this->product->price->amount();
    }

    public function inStock()
    {
        return $this->stockCount() > 0;
    }

    public function stockCount()
    {
        return $this->stock->sum('pivot.stock');
    }

    /**
     * Relationships setup goes below
     */



    public function type()
    {
        return $this->hasOne(ProductVariationType::class, 'id', 'product_variation_type_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function stock()
    {
        return $this->belongsToMany(
            ProductVariation::class,
            'product_variation_stock_view'
        )->withPivot([
            'stock',
            'in_stock'
        ]);
    }

    public function newCollection(array $models = [])
    {
        # code...

        return new ProductVariationCollection($models);
    }
}
