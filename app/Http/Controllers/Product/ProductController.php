<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Models\Product;


class ProductController extends Controller
{
    private $products;

    public function __construct(Product $products)
    {
        $this->products = $products;
    }

    public function index()
    {
        $breadcrumbs = [
            ['link' => "/products", 'name' => "Products"], ['name' => "Index"]
        ];
        $providers = Provider::all();
        $products = Product::with('provider')->paginate(10);

        return view('products.index', compact('products','providers', 'breadcrumbs'));
    }

    public function storeOrUpdate(Request $request)
{

    $isUpdate = $request->has('id') && !empty($request->input('id'));
    if ($isUpdate) {

        $rules = [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'min_amount' => 'nullable||numeric|min:0',
            'max_amount' => 'nullable||numeric|min:0',
            'provider' => 'nullable|exists:providers,id',
            'status' => 'nullable|string|in:active,inactive'
        ];

        $validatedData = $request->validate($rules);
        $products = Product::find($request->input('id'));
        $products->fill(array_filter($validatedData));
        $products->save();

    } else {

        $rules = [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|min:0',
            'provider' => 'required|exists:providers,id',
            'status' => 'required|string|in:active,inactive'
        ];

        $validatedData = $request->validate($rules);
        $products = Product::create($validatedData);
    }


    return redirect()->back()->with('success', 'Record updated or inserted successfully!');
}
}
