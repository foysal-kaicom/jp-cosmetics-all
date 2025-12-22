<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function list(Request $request){
        $product_id = $request->input('product_id');

        if(isset($product_id) && $product_id != null){
            $wishlists = Wishlist::where('product_id', $product_id)->paginate(15);
        }
        else{
            $wishlists = Wishlist::paginate(15);
        }

        $products = Product::select('id', 'name')->get();
        return view('wishlists.list', compact('wishlists', 'products'));
    }
}
