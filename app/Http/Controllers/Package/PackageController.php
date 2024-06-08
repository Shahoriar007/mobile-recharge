<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Product;
use Illuminate\Http\Request;

class PackageController extends Controller
{

    private $packages;

    public function __construct(Package $packages)
    {
        $this->packages = $packages;
    }

    public function index()
    {
        $breadcrumbs = [
            ['link' => "/packages", 'name' => "Packages"], ['name' => "Index"]
        ];
        $packages = $this->packages->latest('created_at')->paginate(10);
        $products = Product::all();

        return view('packages.index', compact('packages','products', 'breadcrumbs'));
    }

    public function storeOrUpdate(Request $request)
{

    $isUpdate = $request->has('id') && !empty($request->input('id'));
    if ($isUpdate) {

        $rules = [
            'regi_charge' => 'nullable|numeric|min:0',
            'regi_bonus' => 'nullable|numeric|min:0',
            'regi_cashback' => 'nullable|numeric|min:0',
            'trans_charge' => 'nullable|numeric|min:0',
            'trans_bonus' => 'nullable|numeric|min:0',
            'charge_free_trans' => 'nullable|numeric|min:0',
            'daily_charge' => 'nullable|numeric|min:0',
            'daily_bonus' => 'nullable|numeric|min:0',
            'refer_plan' => 'nullable|numeric|min:0',
            'stock_limit' => 'nullable|numeric|min:0',
            'withdraw_limit' => 'nullable|numeric|min:0',
            'offline_requ' => 'nullable|numeric|min:0'
        ];

        $validatedData = $request->validate($rules);
        $packages = Package::find($request->input('id'));
        $packages->fill(array_filter($validatedData));
        $packages->save();

    } else {

        $rules = [
            'regi_charge' => 'required|numeric|min:0',
            'regi_bonus' => 'required|numeric|min:0',
            'regi_cashback' => 'required|numeric|min:0',
            'trans_charge' => 'required|numeric|min:0',
            'trans_bonus' => 'required|numeric|min:0',
            'charge_free_trans' => 'required|numeric|min:0',
            'daily_charge' => 'required|numeric|min:0',
            'daily_bonus' => 'required|numeric|min:0',
            'refer_plan' => 'required|numeric|min:0',
            'stock_limit' => 'required|numeric|min:0',
            'withdraw_limit' => 'required|numeric|min:0',
            'offline_requ' => 'required|numeric|min:0'
        ];

        $validatedData = $request->validate($rules);
        $packages = Package::create($validatedData);
    }


    return redirect()->back()->with('success', 'Record updated or inserted successfully!');
}


public function destroy(Request $request)
{
    $packageId = $request->input('package_id');
    $package = Package::findOrFail($packageId);

    $package->delete();
    \Session::flash('success', 'Package successfully deleted.');

    return redirect()->route('packages');
}

public function productConfigure(Request $request){
    dd($request->input('package_id'));
}

}
