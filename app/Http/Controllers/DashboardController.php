<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\SetupPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function customerDashboard(Request $request)
    {
        $search = $request->get('search', '');
        $category = $request->get('category', '');
        $allowedCategories = ['course', 'digital', 'setup'];

        if (!in_array($category, $allowedCategories)) {
            $category = '';
        }

        $items = collect();

        if ($category === 'setup') {
            $setupQuery = SetupPackage::where('status', 'Active');
            if ($search) {
                $setupQuery->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
                });
            }
            $setupList = $setupQuery->orderBy('id', 'desc')->get();
            $items = $setupList->map(function ($setup) {
                $setup->is_setup = true;
                $setup->icon = '🛠️';
                return $setup;
            });
        } elseif ($category === 'course' || $category === 'digital') {
            $prodQuery = Product::where('category', $category);
            if ($search) {
                $prodQuery->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
                });
            }
            $productsList = $prodQuery->orderBy('id', 'desc')->get();
            $items = $productsList->map(function ($product) {
                $product->is_setup = false;
                return $product;
            });
        } else {
            // All categories
            $prodQuery = Product::query();
            if ($search) {
                $prodQuery->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
                });
            }
            $productsList = $prodQuery->orderBy('id', 'desc')->get();

            $setupQuery = SetupPackage::where('status', 'Active');
            if ($search) {
                $setupQuery->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
                });
            }
            $setupList = $setupQuery->orderBy('id', 'desc')->get();

            $setupItems = $setupList->map(function ($setup) {
                $setup->is_setup = true;
                $setup->icon = '🛠️';
                return $setup;
            });

            $productItems = $productsList->map(function ($product) {
                $product->is_setup = false;
                return $product;
            });

            $items = $productItems->concat($setupItems)->sortByDesc(function ($item) {
                return $item->created_at;
            })->values();
        }

        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $perPage = 4;
        $currentItems = $items->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems,
            $items->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('dashboard.customer', [
            'products' => $products,
            'search' => $search,
            'category' => $category
        ]);
    }

    public function mitraDashboard()
    {
        $user = Auth::user();
        
        // Get all orders for Mitra dashboard
        $orders = Order::with(['user', 'product'])->orderBy('id', 'desc')->paginate(5, ['*'], 'orders_page');

        // Get setup services created by this Mitra
        $services = SetupPackage::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(5, ['*'], 'services_page');

        return view('dashboard.mitra', [
            'orders' => $orders,
            'services' => $services
        ]);
    }

    // Store a new Setup Service
    public function storeSetupService(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:OBS Setup,TikTok Live Setup,YouTube Streaming Setup,Audio Setup,Overlay Setup',
            'price' => 'required|numeric',
            'status' => 'required|in:Active,Inactive',
            'estimation' => 'nullable|string|max:255',
            'platforms' => 'nullable|array',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('setup_packages', 'public');
        }

        SetupPackage::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description ?? '',
            'status' => $request->status,
            'estimation' => $request->estimation,
            'platforms' => $request->platforms ? implode(',', $request->platforms) : null,
            'image' => $imagePath,
        ]);

        return redirect()->route('dashboard.mitra')->with('success', 'Jasa setup berhasil ditambahkan!');
    }

    // Update a Setup Service
    public function updateSetupService(Request $request, $id)
    {
        $service = SetupPackage::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:OBS Setup,TikTok Live Setup,YouTube Streaming Setup,Audio Setup,Overlay Setup',
            'price' => 'required|numeric',
            'status' => 'required|in:Active,Inactive',
            'estimation' => 'nullable|string|max:255',
            'platforms' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description ?? '',
            'status' => $request->status,
            'estimation' => $request->estimation,
            'platforms' => $request->platforms ? implode(',', $request->platforms) : null,
        ];

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($service->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('setup_packages', 'public');
        }

        $service->update($data);

        return redirect()->route('dashboard.mitra')->with('success', 'Jasa setup berhasil diperbarui!');
    }

    // Delete a Setup Service
    public function destroySetupService($id)
    {
        $service = SetupPackage::where('user_id', Auth::id())->findOrFail($id);
        
        // Hapus gambar dari storage
        if ($service->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($service->image);
        }
        
        $service->delete();

        return redirect()->route('dashboard.mitra')->with('success', 'Jasa setup berhasil dihapus!');
    }

    // Accept incoming Order
    public function acceptOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'accepted']);

        return redirect()->route('dashboard.mitra')->with('success', 'Order berhasil diterima!');
    }

    // Reject incoming Order
    public function rejectOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'rejected']);

        return redirect()->route('dashboard.mitra')->with('success', 'Order ditolak!');
    }

    // Complete incoming Order
    public function completeOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'completed']);

        return redirect()->route('dashboard.mitra')->with('success', 'Order diselesaikan!');
    }
}
