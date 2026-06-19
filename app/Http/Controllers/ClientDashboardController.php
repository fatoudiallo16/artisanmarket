<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ClientDashboardController extends Controller
{
    public function index(): View
    {
        return view('client.dashboard.index');
    }
}
