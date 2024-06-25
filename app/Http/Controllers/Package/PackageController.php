<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use App\Models\AddBalance;
use App\Models\Balance;
use App\Models\BalanceBonus;
use App\Models\Drive;
use App\Models\DriveCommission;
use App\Models\DriveCommissions;
use App\Models\Gateway;
use App\Models\Method;
use App\Models\Package;
use App\Models\Product;
use App\Models\ProductConfig;
use App\Models\WithdrawCredit;
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
        $gateways = Gateway::all();
        $methods = Method::all();
        $drives = Drive::all();
        $balances = Balance::all();
        return view('packages.index', compact('packages','products','gateways','methods','drives','balances', 'breadcrumbs'));
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
    $products = $request->input('products', []);
    $selectedProducts = array_filter($products, function ($productData) {
        if( isset($productData['selected']) && $productData['selected'] == '1' ){
            $rules = [
                'product_id' => 'required|exists:products,id',
                'package_id' => 'required|exists:packages,id',
                'commission' => 'required|numeric|min:0',
                'charge' => 'required|numeric|min:0',
            ];
            try {
                $validator = \Validator::make($productData, $rules);
                if ($validator->fails()) {
                    return false;
                }
                $fieldsToStore = ['product_id', 'package_id', 'commission', 'charge'];
                $filteredData = array_intersect_key($productData, array_flip($fieldsToStore));
                ProductConfig::create($filteredData);
            } catch (\Exception $e) {
                return false;
            }

        }
    });

}

public function addBalance(Request $request){
    $gateways = $request->input('gateways', []);
    $selectedGateways = array_filter($gateways, function ($gatewayData) {
        if( isset($gatewayData['selected']) && $gatewayData['selected'] == '1' ){
            $rules = [
                'gateway_id' => 'required|exists:gateways,id',
                'package_id' => 'required|exists:packages,id',
                'commission' => 'required|numeric|min:0',
                'charge' => 'required|numeric|min:0',
            ];
            try {
                $validator = \Validator::make($gatewayData, $rules);

                if ($validator->fails()) {
                    return false;
                }
                $fieldsToStore = ['gateway_id', 'package_id', 'commission', 'charge'];
                $filteredData = array_intersect_key($gatewayData, array_flip($fieldsToStore));
                AddBalance::create($filteredData);
            } catch (\Exception $e) {

                return false;
            }

        }
    });
}

public function withdrawCredit(Request $request){
    $methods = $request->input('methods', []);
    $selectedMethods = array_filter($methods, function ($methodData) {
        if( isset($methodData['selected']) && $methodData['selected'] == '1' ){
            $rules = [
                'method_id' => 'required|exists:methods,id',
                'package_id' => 'required|exists:packages,id',
                'commission' => 'required|numeric|min:0',
                'charge' => 'required|numeric|min:0',
            ];
            try {
                $validator = \Validator::make($methodData, $rules);

                if ($validator->fails()) {
                    return false;
                }
                $fieldsToStore = ['method_id', 'package_id', 'commission', 'charge'];
                $filteredData = array_intersect_key($methodData, array_flip($fieldsToStore));
                WithdrawCredit::create($filteredData);
            } catch (\Exception $e) {

                return false;
            }

        }
    });
}

public function balanceBonus(Request $request){
    $balances = $request->input('balances', []);
    $selectedBalances = array_filter($balances, function ($balanceData) {
        if( isset($balanceData['selected']) && $balanceData['selected'] == '1' ){
            $rules = [
                'balance_id' => 'required|exists:balances,id',
                'package_id' => 'required|exists:packages,id',
                'commission' => 'required|numeric|min:0',
                'charge' => 'required|numeric|min:0',
            ];
            try {
                $validator = \Validator::make($balanceData, $rules);

                if ($validator->fails()) {
                    return false;
                }
                $fieldsToStore = ['balance_id', 'package_id', 'commission', 'charge'];
                $filteredData = array_intersect_key($balanceData, array_flip($fieldsToStore));
                BalanceBonus::create($filteredData);
            } catch (\Exception $e) {

                return false;
            }

        }
    });
}

public function driveCommission(Request $request){
    $drives = $request->input('drives', []);
    $selectedDrives = array_filter($drives, function ($drivedata) {
        if( isset($drivedata['selected']) && $drivedata['selected'] == '1' ){
            $rules = [
                'drive_id' => 'required|exists:drives,id',
                'package_id' => 'required|exists:packages,id',
                'commission' => 'required|numeric|min:0',
                'charge' => 'required|numeric|min:0',
            ];
            try {
                $validator = \Validator::make($drivedata, $rules);

                if ($validator->fails()) {
                    return false;
                }
                $fieldsToStore = ['drive_id', 'package_id', 'commission', 'charge'];
                $filteredData = array_intersect_key($drivedata, array_flip($fieldsToStore));
                DriveCommission::create($filteredData);
            } catch (\Exception $e) {

                return false;
            }

        }
    });
}

}
