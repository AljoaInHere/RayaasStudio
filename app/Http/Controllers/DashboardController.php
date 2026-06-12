<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\SetupPackage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            $teknisiQuery = User::where('role', 'mitra')
                ->whereHas('setupPackages', function ($q) {
                    $q->where('status', 'Active');
                })
                ->with(['setupPackages' => function ($q) {
                    $q->where('status', 'Active');
                }]);

            if ($search) {
                $teknisiQuery->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('username', 'like', '%' . $search . '%');
                });
            }

            $teknisiList = $teknisiQuery->orderBy('id', 'desc')->get();

            $items = $teknisiList->map(function ($teknisi) {
                return (object) [
                    'id' => $teknisi->id,
                    'name' => $teknisi->username,
                    'description' => 'Teknisi Ahli Setup',
                    'is_setup' => true,
                    'icon' => '👨🔧',
                    'min_price' => $teknisi->setupPackages->min('price'),
                    'max_price' => $teknisi->setupPackages->max('price'),
                    'created_at' => $teknisi->created_at,
                    'profile_photo' => $teknisi->profile_photo,
                    'bio' => $teknisi->bio,
                ];
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
                $product->min_price = null;
                $product->max_price = null;
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

            $teknisiQuery = User::where('role', 'mitra')
                ->whereHas('setupPackages', function ($q) {
                    $q->where('status', 'Active');
                })
                ->with(['setupPackages' => function ($q) {
                    $q->where('status', 'Active');
                }]);

            if ($search) {
                $teknisiQuery->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('username', 'like', '%' . $search . '%');
                });
            }

            $teknisiList = $teknisiQuery->orderBy('id', 'desc')->get();

            $setupItems = $teknisiList->map(function ($teknisi) {
                return (object) [
                    'id' => $teknisi->id,
                    'name' => $teknisi->username,
                    'description' => 'Teknisi Ahli Setup',
                    'is_setup' => true,
                    'icon' => '👨🔧',
                    'min_price' => $teknisi->setupPackages->min('price'),
                    'max_price' => $teknisi->setupPackages->max('price'),
                    'created_at' => $teknisi->created_at,
                    'profile_photo' => $teknisi->profile_photo,
                    'bio' => $teknisi->bio,
                ];
            });

            $productItems = $productsList->map(function ($product) {
                $product->is_setup = false;
                $product->min_price = null;
                $product->max_price = null;
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
        $orders = Order::with(['user', 'product', 'setupPackage'])->orderBy('id', 'desc')->paginate(5, ['*'], 'orders_page');

        // Get setup services created by this Mitra
        $services = SetupPackage::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(5, ['*'], 'services_page');

        // Global statistics (across all pagination pages)
        $totalOrdersCount = Order::count();
        $completedOrdersCount = Order::where(function($q) {
            $q->where('status', 'completed')
              ->orWhere(function($sub) {
                  $sub->whereNotNull('product_id')
                      ->where('status', 'paid');
              });
        })->count();

        $totalRevenue = Order::where(function($q) {
            $q->where('status', 'completed')
              ->orWhere(function($sub) {
                  $sub->whereNotNull('product_id')
                      ->where('status', 'paid');
              });
        })->sum('harga');

        // Query tren pendapatan 6 bulan terakhir (completed orders & paid product orders)
        $sixMonthsAgo = Carbon::now()->subMonths(5)->startOfMonth();
        $revenueData = Order::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(harga) as total')
            )
            ->where(function($q) {
                $q->where('status', 'completed')
                  ->orWhere(function($sub) {
                      $sub->whereNotNull('product_id')
                          ->where('status', 'paid');
                  });
            })
            ->where('created_at', '>=', $sixMonthsAgo)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $chartMonths = [];
        $chartRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthObj = Carbon::now()->subMonths($i);
            $monthKey = $monthObj->format('Y-m');
            $chartMonths[] = $monthObj->translatedFormat('F Y');
            $chartRevenue[] = (float)($revenueData[$monthKey] ?? 0);
        }

        // Query kategori terlaris (gabungan produk digital/course & jasa setup)
        $allPaidOrders = Order::with(['product', 'setupPackage'])
            ->whereIn('status', ['paid', 'pending', 'accepted', 'completed'])
            ->get();

        $categoryCounts = [];
        foreach ($allPaidOrders as $order) {
            $categoryName = null;
            if ($order->setupPackage) {
                $categoryName = $order->setupPackage->category;
            } elseif ($order->product) {
                $categoryName = $order->product->category == 'course' ? 'Course' : ($order->product->category == 'digital' ? 'Digital Product' : ucfirst($order->product->category));
            }
            
            if ($categoryName) {
                if (!isset($categoryCounts[$categoryName])) {
                    $categoryCounts[$categoryName] = 0;
                }
                $categoryCounts[$categoryName]++;
            }
        }
        
        arsort($categoryCounts);
        $chartCategories = array_keys($categoryCounts);
        $chartSales = array_values($categoryCounts);

        return view('dashboard.mitra', [
            'orders' => $orders,
            'services' => $services,
            'totalOrdersCount' => $totalOrdersCount,
            'completedOrdersCount' => $completedOrdersCount,
            'totalRevenue' => $totalRevenue,
            'chartMonths' => $chartMonths,
            'chartRevenue' => $chartRevenue,
            'chartCategories' => $chartCategories,
            'chartSales' => $chartSales
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
