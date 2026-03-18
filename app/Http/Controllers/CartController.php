<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{



    public function createCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required',
            'email' => 'required',
            'name' => 'required',
            'total' => 'required',
            'items' => 'required|array',
            'items.*.productId' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorLists' => $validator->errors()], 403);
        }

        $cart = Cart::create([
            'address' => $request->address,
            'email' => $request->email,
            'name' => $request->name,
            'total_price' => $request->total,
        ]);
        foreach ($request->items as $item) {
            CartItem::create([
                'cart_id' => $cart->id,
                'price'=> Product::find($item['productId'])->price,
                'product_id' => $item['productId'],
                'quantity' => $item['quantity'],
            ]);
        } 
              
        return response()->json(['cart_id' => $cart->id], 201);
    }

    public function listCart()
    {
        $carts = Cart::with(['items.product'])->orderBy('created_at', 'desc')->get();
        return response()->json($carts);
    }

    public function updateStatus(Request $request, $id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $statusFlow = ['waiting', 'confirmed', 'completed'];
        $current = $cart->status;
        $currentIndex = array_search($current, $statusFlow, true);

        if ($currentIndex === false) {
            $cart->status = 'waiting';
            $cart->save();
            return response()->json($cart);
        }

        if ($currentIndex >= count($statusFlow) - 1) {
            return response()->json(['message' => 'Cart already completed', 'cart' => $cart], 200);
        }

        $cart->status = $statusFlow[$currentIndex + 1];
        $cart->save();

        return response()->json($cart);
    }

    public function destroy($id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $cart->items()->delete();
        $cart->delete();

        return response()->json(['message' => 'Cart deleted'], 200);
    }
}
