<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FavorisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $user = Auth::user();
        $favoris = $user->favoris()->with('categorie')->get();

        return view('public.favoris.index', compact('favoris'));
    }

    public function toggle(Request $request, Produit $produit)
    {
        $user = Auth::user();
        
        if ($user->favoris()->where('produit_id', $produit->id)->exists()) {
            $user->favoris()->detach($produit->id);
            $isFavorite = false;
            $message = 'Produit retiré des favoris.';
        } else {
            $user->favoris()->attach($produit->id);
            $isFavorite = true;
            $message = 'Produit ajouté aux favoris.';
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_favorite' => $isFavorite,
                'message' => $message,
                'count' => $user->favoris()->count(),
            ]);
        }

        return back()->with('success', $message);
    }
}
