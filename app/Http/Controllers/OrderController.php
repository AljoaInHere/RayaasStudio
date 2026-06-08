<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        if (strtolower(trim(Auth::user()->role)) == 'mitra') {
            $orders = Order::with(['user', 'product'])->get();
        } else {
            $orders = Order::with(['user', 'product'])
                ->where('user_id', Auth::id())->get();
        }
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'nama' => 'required',
            'metode' => 'required',
        ]);

        $product = Product::findOrFail($request->product_id);

        Order::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'paket' => $product->name,
            'harga' => $product->price,
            'nama' => $request->nama,
            'metode' => $request->metode,
            'status' => 'completed',
        ]);

        return redirect()->route('orders.index')->with('success', 'Order berhasil dibuat!');
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();
        return redirect()->route('orders.index')->with('success', 'Order berhasil dihapus!');
    }
}