<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\SetupPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Payment untuk Product
    public function showProductPayment($id)
    {
        $product = Product::findOrFail($id);
        return view('payment.product', compact('product'));
    }

    public function processProductPayment(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'metode' => 'required|string',
        ]);

        $product = Product::findOrFail($id);

        Order::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'nama' => $request->nama,
            'metode' => $request->metode,
            'status' => 'completed',
            'harga' => $product->price,
        ]);

        return redirect()->route('dashboard.customer')->with('success', 'Pembayaran berhasil!');
    }

    // Payment untuk Setup Package
    public function showSetupPayment($id)
    {
        $package = SetupPackage::findOrFail($id);
        return view('payment.setup', compact('package'));
    }

    public function processSetupPayment(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'metode' => 'required|string',
        ]);

        $package = SetupPackage::findOrFail($id);

        Order::create([
            'user_id' => Auth::id(),
            'setup_package_id' => $package->id,
            'paket' => $package->name,
            'harga' => $package->price,
            'nama' => $request->nama,
            'metode' => $request->metode,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard.customer')->with('success', 'Pembayaran berhasil!');
    }

    // QRIS Payment Page
    public function showQris($type, $id, Request $request)
    {
        $nama = $request->query('nama', '');

        if ($type === 'product') {
            $product = Product::findOrFail($id);
            $itemName = $product->name;
            $price = $product->price;
        } elseif ($type === 'setup') {
            $package = SetupPackage::findOrFail($id);
            $itemName = $package->name . ' Package';
            $price = $package->price;
        } else {
            abort(404);
        }

        return view('payment.qris', [
            'type' => $type,
            'itemId' => $id,
            'itemName' => $itemName,
            'price' => $price,
            'nama' => $nama,
        ]);
    }

    // Process QRIS Payment via AJAX
    public function processQris(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('id');
        $nama = $request->input('nama');

        if ($type === 'product') {
            $product = Product::findOrFail($id);
            Order::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'nama' => $nama,
                'metode' => 'qris',
                'status' => 'completed',
                'harga' => $product->price,
            ]);
        } elseif ($type === 'setup') {
            $package = SetupPackage::findOrFail($id);
            Order::create([
                'user_id' => Auth::id(),
                'setup_package_id' => $package->id,
                'paket' => $package->name,
                'harga' => $package->price,
                'nama' => $nama,
                'metode' => 'qris',
                'status' => 'pending',
            ]);
        }

        return response()->json(['success' => true]);
    }
}
