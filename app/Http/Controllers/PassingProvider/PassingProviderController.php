<?php

namespace App\Http\Controllers\PassingProvider;

use App\Http\Controllers\Controller;
use App\Models\PassingProvider;
use App\Models\Product;
use App\Models\ProviderResponse;
use App\Models\Terminal;
use Exception;
use Illuminate\Http\Request;

class PassingProviderController extends Controller
{
    private $passingProvider;

    public function __construct(PassingProvider $passingProvider)
    {
        $this->passingProvider = $passingProvider;
    }

    public function index()
    {
        $breadcrumbs = [
            ['link' => "/passingProvider", 'name' => "PassingProvider"], ['name' => "Index"]
        ];
        $products = Product::all();
        $terminals = Terminal::all();
        $providerResponses = ProviderResponse::all();
        $passingProviders = $this->passingProvider->latest('created_at')->paginate(10);

        return view('passingProvider.index', compact('passingProviders','products', 'terminals','providerResponses', 'breadcrumbs'));
    }

    public function storeOrUpdate(Request $request)
{

    $isUpdate = $request->has('id') && !empty($request->input('id'));
    if ($isUpdate) {

        $rules = [
            'passing_provider_id' => 'required',
            'product_id' => 'nullable',
            'terminal_id' => 'nullable',
            'provider_response_id' => 'nullable',
            'format' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ];

        $validatedData = $request->validate($rules);
        $passingProvider = PassingProvider::find($request->input('id'));
        $passingProvider->fill(array_filter($validatedData));
        $passingProvider->save();

    } else {


        try{
            $rules = [
            'passing_provider_id' => 'nullable',
            'product_id' => 'required',
            'terminal_id' => 'required',
            'provider_response_id' => 'required',
            'format' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            ];


        $validatedData = $request->validate($rules);
        $passingProvider = PassingProvider::create($validatedData);
    }
    catch (Exception $e) {
        info($e);
    }
    }


    return redirect()->back()->with('success', 'Record updated or inserted successfully!');
}

public function destroy(Request $request)
{
    $passingProviderId = $request->input('provider_id');
    $passingProvider = PassingProvider::findOrFail($passingProviderId);

    $passingProvider->delete();
    \Session::flash('success', 'Provider and associated offers and products are successfully deleted.');

    return redirect()->route('passingProvider');
}
}
