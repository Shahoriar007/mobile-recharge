<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class ProviderController extends Controller
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

        return view('providers.index', compact('users', 'breadcrumbs'));
    }
}
