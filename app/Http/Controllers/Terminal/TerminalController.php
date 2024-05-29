<?php

namespace App\Http\Controllers\Terminal;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Models\Terminal;
use Illuminate\Http\Request;

class TerminalController extends Controller
{
    private $terminals;

    public function __construct(Terminal $terminals)
    {
        $this->terminals = $terminals;
    }

    public function index()
    {
        $breadcrumbs = [
            ['link' => "/terminals", 'name' => "terminals"], ['name' => "Index"]
        ];
        $terminals = $this->terminals->latest('created_at')->paginate(10);
        $providers = Provider::all();

        return view('terminals.index', compact('terminals','providers', 'breadcrumbs'));
    }

    public function storeOrUpdate(Request $request)
{

    $isUpdate = $request->has('id') && !empty($request->input('id'));
    if ($isUpdate) {
        $rules = [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric|min:0',
            'user' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:active,inactive',
            'provider_id' => 'nullable|exists:providers,id',

        ];

        $validatedData = $request->validate($rules);
        $terminals = Terminal::find($request->input('id'));
        $terminals->fill(array_filter($validatedData));
        $terminals->save();

    } else {

        $rules = [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'user' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'status' => 'required|string|in:active,inactive',
            'provider_id' => 'required|exists:providers,id',

        ];

        $validatedData = $request->validate($rules);
        $terminals = Terminal::create($validatedData);
    }


    return redirect()->back()->with('success', 'Record updated or inserted successfully!');
}

public function destroy(Request $request)
{
    $terminalId = $request->input('terminal_id');
    $terminal = Terminal::findOrFail($terminalId);

    $terminal->delete();
    \Session::flash('success', 'Provider and associated offers and products are successfully deleted.');

    return redirect()->route('terminals');
}

}
