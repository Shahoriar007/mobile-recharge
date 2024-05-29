<?php

namespace App\Http\Controllers\ProviderResponse;

use App\Http\Controllers\Controller;
use App\Models\ProviderResponse;
use Exception;
use Illuminate\Http\Request;

class ProviderResponseController extends Controller
{
    private $providerResponse;

    public function __construct(ProviderResponse $providerResponse)
    {
        $this->providerResponse = $providerResponse;
    }

    public function index()
    {
        $breadcrumbs = [
            ['link' => "/providerResponses", 'name' => "ProviderResponses"], ['name' => "Index"]
        ];

        $providerResponses = $this->providerResponse->latest('created_at')->paginate(10);

        return view('providerResponses.index', compact('providerResponses', 'breadcrumbs'));
    }

    public function storeOrUpdate(Request $request)
{

    $isUpdate = $request->has('id') && !empty($request->input('id'));
    if ($isUpdate) {

        $rules = [
            'code' => 'required|string|max:255',
            'before_balance' => 'nullable|string|max:255',
            'after_balance' => 'nullable|string|max:255',
            'before_amount' => 'nullable|string|max:255',
            'after_amount' => 'nullable|string|max:255',
            'before_trans_code' => 'nullable|string|max:255',
            'after_trans_code' => 'nullable|string|max:255',
            'must_include' => 'nullable|string|max:255',
            'feedback' => 'nullable|string|max:255',
        ];

        $validatedData = $request->validate($rules);
        $providerResponse = ProviderResponse::find($request->input('id'));
        $providerResponse->fill(array_filter($validatedData));
        $providerResponse->save();

    } else {


        try{
            $rules = [
                'code' => 'required|string|max:255',
                'before_balance' => 'required|string|max:255',
                'after_balance' => 'required|string|max:255',
                'before_amount' => 'required|string|max:255',
                'after_amount' => 'required|string|max:255',
                'before_trans_code' => 'required|string|max:255',
                'after_trans_code' => 'required|string|max:255',
                'must_include' => 'required|string|max:255',
                'feedback' => 'required|string|max:255',
            ];


        $validatedData = $request->validate($rules);
        $providerResponse = ProviderResponse::create($validatedData);
    }
    catch (Exception $e) {
        info($e);
    }
    }


    return redirect()->back()->with('success', 'Record updated or inserted successfully!');
}

public function destroy(Request $request)
{
    $providerResponseId = $request->input('provider_id');
    $providerResponse = ProviderResponse::findOrFail($providerResponseId);

    $providerResponse->delete();
    \Session::flash('success', 'Provider and associated offers and products are successfully deleted.');

    return redirect()->route('providerResponses');
}

}
