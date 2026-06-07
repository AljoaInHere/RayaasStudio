<?php

namespace App\Http\Controllers;

use App\Models\SetupPackage;
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
}
