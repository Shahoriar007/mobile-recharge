<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function index()
    {
        $breadcrumbs = [
            ['link' => "/users", 'name' => "Users"], ['name' => "Index"]
        ];

        $users = $this->user->latest('created_at')->paginate(10);

        return view('users.index', compact('users', 'breadcrumbs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        Session::flash('success', 'User successfully created.');

        return redirect()->route('users');
    }

    public function edit(User $user)
    {
        $userData = User::findOrFail($user->id);

        return response()->json($userData);
    }

    public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'password' => 'nullable|string|min:6',
    ]);

    $user = User::find($id);

    if (isset($validatedData['password']) && $validatedData['password'] !== null) {
        $validatedData['password'] = Hash::make($validatedData['password']);
    } else {
        unset($validatedData['password']);
    }

    $user->update($validatedData);

    Session::flash('success', 'User successfully updated.');

    return redirect()->route('users');
}

public function destroy(Request $request)
{

    $userId = $request->input('user_id');
    $user = User::findOrFail($userId);

    $user->delete();

    Session::flash('success', 'User successfully deleted.');

    return redirect()->route('users');
}


}
