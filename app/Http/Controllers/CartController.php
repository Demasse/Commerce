<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Récupérer ou créer le panier de l'utilisateur connecté
    private function getUserCart()
    {
        return Cart::firstOrCreate([
            'user_id' => Auth::id(),
        ]);
    }

    // Afficher le panier (avec les produits liés)
    public function index()
    {
        $cart = $this->getUserCart()->load('items.product');

        return response()->json([
            'cart' => $cart,
        ]);
    }

    // Ajouter un produit au panier
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantityToAdd = $request->quantity ?? 1;

        if ($product->stock < $quantityToAdd) {
            return response()->json([
                'message' => 'Stock insuffisant pour ce produit.',
            ], 422);
        }

        $cart = $this->getUserCart();

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $newQty = $item->quantity + $quantityToAdd;
            if ($product->stock < $newQty) {
                return response()->json([
                    'message' => 'Vous avez atteint le stock maximum disponible.',
                ], 422);
            }
            $item->update(['quantity' => $newQty]);
        } else {
            $item = $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantityToAdd,
            ]);
        }

        return response()->json([
            'message' => 'Produit ajouté au panier.',
            'cart' => $cart->load('items.product'),
        ], 201);
    }

    // Modifier la quantité d'un article du panier
    public function update(Request $request, CartItem $cartItem)
    {
        $cart = $this->getUserCart();
        if ($cartItem->cart_id !== $cart->id) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($cartItem->product->stock < $request->quantity) {
            return response()->json([
                'message' => 'Stock insuffisant.',
            ], 422);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json([
            'message' => 'Quantité mise à jour.',
            'cart' => $cart->load('items.product'),
        ]);
    }

    // Supprimer un article du panier
    public function destroy(CartItem $cartItem)
    {
        $cart = $this->getUserCart();
        if ($cartItem->cart_id !== $cart->id) {
            abort(403);
        }

        $cartItem->delete();

        return response()->json([
            'message' => 'Article retiré du panier.',
            'cart' => $cart->load('items.product'),
        ]);
    }
}
