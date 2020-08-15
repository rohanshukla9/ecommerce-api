<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CartAddRequest;
use Illuminate\Http\Request;
use App\Cart\Cart;
use App\Http\Requests\Cart\CartUpdateRequest;
use App\Http\Resources\Cart\CartResource;
use App\Models\ProductVariation;

class CartController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware(['auth:api']);

    }

    public function index(Request $request, Cart $cart)
    {
        $cart->sync();

        $request->user()->load(['cart.product', 'cart.product.variations.stock', 'cart.stock', 'cart.type']);

        return (new CartResource($request->user()))
            ->additional([
                'meta' => $this->meta($cart)
            ]);
    }

    protected function meta(Cart $cart)
    {
        return [
            'empty' => $cart->isEmpty(),
            'subtotal' => $cart->subtotal()->formatted(),
            'total' =>  $cart->total()->formatted(),
            'changed' => $cart->hasChanged(),
        ];
    }

    public function store(CartAddRequest $request, Cart $cart)
    {
        
        // $products = $request->products;

        // $products = collect($products)->keyBy('id')->map(function($product){
        //     return [
        //         'quantity' => $product['quantity']
        //     ];
        // })->toArray();


        // $request->user()->cart()->syncWithoutDetaching($products);

        $cart->add($request->products);

    }

    public function update(ProductVariation $productVariation, CartUpdateRequest $request, Cart $cart)
    {
        //dd($productVariation);

        $cart->update($productVariation->id, $request->quantity);
    }

    public function destroy(ProductVariation $productVariation, Cart $cart)
    {
        //dd($productVariation);

        $cart->delete($productVariation->id);
    }


}
