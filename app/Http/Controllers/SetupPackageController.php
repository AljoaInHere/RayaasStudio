<?php

namespace App\Http\Controllers;

use App\Models\SetupPackage;
use App\Models\User;
use Illuminate\Http\Request;

class SetupPackageController extends Controller
{
    public function index()
    {
        $packages = SetupPackage::all();
        return view('setup.index', compact('packages'));
    }

    public function show($id)
    {
        $package = SetupPackage::findOrFail($id);
        return view('setup.detail', compact('package'));
    }

    public function payment($id)
    {
        $package = SetupPackage::findOrFail($id);
        return view('setup.payment', compact('package'));
    }

    public function showTeknisi($id)
    {
        $teknisi = User::where('role', 'mitra')
            ->with(['setupPackages' => function ($q) {
                $q->where('status', 'Active');
            }, 'portfolios'])
            ->findOrFail($id);

        return view('setup.teknisi_detail', compact('teknisi'));
    }
}
