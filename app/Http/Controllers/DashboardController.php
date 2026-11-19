<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Récupérer les commandes du client avec leurs articles et factures
        $orders = Order::where('user_id', $user->id)
            ->with(['items', 'invoice'])
            ->latest()
            ->get();

        // Récupérer les factures du client
        $invoices = Invoice::where('user_id', $user->id)
            ->with('order')
            ->latest()
            ->get();

        // Calculer le montant total dépensé
        $totalSpent = $orders->sum('total_amount');

        return view('dashboard', compact('user', 'orders', 'invoices', 'totalSpent'));
    }
}
