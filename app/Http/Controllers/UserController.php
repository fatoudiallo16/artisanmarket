<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('role')->latest()->paginate(20);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($users);
        }

        return view('admin.utilisateurs.index', compact('users'));
    }
}
