<?php

namespace App\Http\Controllers\Offer;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Models\Offer;


class OfferController extends Controller
{
    private $offer;

    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    public function index()
    {
        $breadcrumbs = [
            ['link' => "/Offers", 'name' => "Offers"], ['name' => "Index"]
        ];

        $offers = Offer::with('provider')->latest('created_at')->paginate(10);
        $providers = Provider::all();

        return view('offers.index', compact('offers','providers', 'breadcrumbs'));
    }

    public function storeOrUpdate(Request $request)
{
    $isUpdate = $request->has('id') && !empty($request->input('id'));
    if ($isUpdate) {

        $rules = [
            'description' => 'required|string|max:255',
            'provider_id' => 'required|exists:providers,id',
            'type' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'cashback' => 'nullable|numeric|min:0',
        ];

        $validatedData = $request->validate($rules);
        $offer = Offer::find($request->input('id'));
        $offer->fill(array_filter($validatedData));
        $offer->save();

    } else {

        $rules = [
            'description' => 'required|string|max:255',
            'provider_id' => 'required|exists:providers,id',
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'cashback' => 'required|numeric|min:0',
        ];

        $validatedData = $request->validate($rules);
        $offer = Offer::create($validatedData);
    }


    return redirect()->back()->with('success', 'Record updated or inserted successfully!');
}

public function destroy(Request $request)
{
    $offerId = $request->input('offer_id');
    $offer = Offer::findOrFail($offerId);

    $offer->delete();
    \Session::flash('success', 'Offer successfully deleted.');

    return redirect()->route('offers');
}
}
