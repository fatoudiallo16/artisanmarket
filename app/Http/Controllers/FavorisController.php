<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class FavorisController extends Controller
{
    public function index(): View
    {
        return view('public.favoris.index');
    }
}
