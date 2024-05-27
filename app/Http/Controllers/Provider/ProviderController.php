<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Provider;


class ProviderController extends Controller
{
    private $provider;

    public function __construct(Provider $provider)
    {
        $this->provider = $provider;
    }

    public function index()
    {
        $breadcrumbs = [
            ['link' => "/providers", 'name' => "Providers"], ['name' => "Index"]
        ];

        $providers = $this->provider->latest('created_at')->paginate(10);

        return view('providers.index', compact('providers', 'breadcrumbs'));
    }

    public function storeOrUpdate(Request $request)
{
    $isUpdate = $request->has('id') && !empty($request->input('id'));
    if ($isUpdate) {

        $rules = [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'length' => 'nullable|string|max:255',
            'prefix' => 'nullable|string|max:255',
            'category' => 'nullable|string|in:recharge,drive,bill,withdraw',
            'status' => 'nullable|string|in:active,inactive,net_problem,stock_out'
        ];

        $validatedData = $request->validate($rules);
        $provider = Provider::find($request->input('id'));
        $provider->fill(array_filter($validatedData));
        $provider->save();

    } else {

        $rules = [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'length' => 'required|string|max:255',
            'prefix' => 'required|string|max:255',
            'category' => 'required|string|in:recharge,drive,bill,withdraw',
            'status' => 'required|string|in:active,inactive,net_problem,stock_out'
        ];

        $validatedData = $request->validate($rules);
        $provider = Provider::create($validatedData);
    }


    return redirect()->back()->with('success', 'Record updated or inserted successfully!');
}
}
