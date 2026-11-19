<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->with('items.product')->first();

        if (! $cart || $cart->items->isEmpty()) {
            return response()->json([
                'message' => 'Votre panier est vide.',
            ], 422);
        }

        try {
            $result = DB::transaction(function () use ($user, $cart) {
                $totalAmount = 0;

                // 1. Vérifier les stocks et calculer le montant total
                foreach ($cart->items as $item) {
                    $product = $item->product()->lockForUpdate()->first();

                    if (! $product || $product->stock < $item->quantity) {
                        throw new \RuntimeException(
                            "Stock insuffisant pour le produit : " . ($product->name ?? 'inconnu')
                        );
                    }

                    $totalAmount += $product->price * $item->quantity;
                }

                // 2. Créer la commande
                $order = Order::create([
                    'user_id' => $user->id,
                    'reference' => 'CMD-' . now()->format('Ymd') . '-' . strtoupper(uniqid()),
                    'total_amount' => $totalAmount,
                    'status' => 'confirmed',
                ]);

                // 3. Créer les lignes de commande et mettre à jour le stock
                foreach ($cart->items as $item) {
                    $product = $item->product;
                    $subtotal = $product->price * $item->quantity;

                    $order->items()->create([
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'quantity' => $item->quantity,
                        'unit_price' => $product->price,
                        'subtotal' => $subtotal,
                    ]);

                    $product->decrement('stock', $item->quantity);
                }

                // 4. Générer la facture associée
                $invoice = Invoice::create([
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'invoice_number' => 'FAC-' . now()->format('Ymd') . '-' . strtoupper(uniqid()),
                    'amount' => $totalAmount,
                    'status' => 'paid',
                    'issued_at' => now(),
                ]);

                // 5. Vider le panier
                $cart->items()->delete();

                return [
                    'order' => $order->load('items'),
                    'invoice' => $invoice,
                ];
            });

            return response()->json([
                'message' => 'Commande validée et facture générée avec succès !',
                'order' => $result['order'],
                'invoice' => $result['invoice'],
            ], 201);
        } catch (\RuntimeException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la validation de la commande.',
            ], 500);
        }
    }
}
