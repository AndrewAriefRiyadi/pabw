<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::instance('cart')->content();
        return view('cart', ['cartItems' => $cartItems]);
    }

    public function addToCart(Request $request)
    {
        $product = Product::find(($request->id));
        $price = $product->sale_price ? $product->sale_price : $product->regular_price;
        Cart::instance('cart')->add($product->id, $product->name, $request->quantity, $price)->associate('App\Models\Product');
        return redirect()->back()->with('message', 'Success | Items has been added succesfully');
    }
}
