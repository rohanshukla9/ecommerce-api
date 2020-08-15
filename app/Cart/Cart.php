<?php

namespace App\Cart;

use App\Models\User;
use App\Cart\Money;

class Cart
{
    protected $user;

    protected $changed = false;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function products()
    {
        return $this->user->cart;
    }


    public function add($products)
    {
        # code...

        $this->user->cart()->syncWithoutDetaching(
            $this->getStorePayload($products)
        );
    }

    public function update($productId, $quantity)
    {
        # code...

        $this->user->cart()->updateExistingPivot($productId, [
            'quantity' => $quantity
        ]);
    }

    public function delete($productId)
    {
        # code...
        $this->user->cart()->detach($productId);
    }

    public function sync()
    {
        $this->user->cart->each(function ($product) {
            //min qty available and 
            $quantity = $product->minStock($product->pivot->quantity);

            if ($quantity != $product->pivot->quantity) {
                $this->changed = true;
            }




            //update the pivot
            $product->pivot->update([
                'quantity' => $quantity
            ]);
        });
    }


    public function hasChanged()
    {
        return $this->changed;
    }


    public function empty()
    {
        # code...
        $this->user->cart()->detach();
    }

    public function isEmpty()
    {
        return $this->user->cart->sum('pivot.quantity') <= 0;
    }

    public function subtotal()
    {
        $subtotal = $this->user->cart->sum(function ($product) {
            return $product->price->amount() * $product->pivot->quantity;
        });

        return new Money($subtotal);
    }

    public function total()
    {
        //shipping

        return $this->subtotal();
    }



    protected function getStorePayload($products)
    {
        return collect($products)->keyBy('id')->map(function ($product) {
            return [
                'quantity' => $product['quantity'] + $this->getCurrentQuantity($product['id'])
            ];
        })->toArray();
    }

    protected function getCurrentQuantity($productId)
    {
        if ($product = $this->user->cart->where('id', $productId)->first()) {
            return $product->pivot->quantity;
        }

        return 0;
    }
}
