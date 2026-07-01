<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Redirect to the appropriate dashboard based on user role.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $user->loadMissing('role');

        if ($user->hasRole('admin')) {
            return app(AdminDashboardController::class)->index();
        }

        if ($user->hasRole('vendeur')) {
            return app(VendeurDashboardController::class)->index();
        }

        if ($user->hasRole('client')) {
            return redirect()->route('welcome');
        }

        return redirect()->route('welcome');
    }
}
