<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\Lignepanier;
use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PanierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // afficher le panier de l'utilisateur
    public function index(): View
    {
        $panier = Panier::firstOrCreate(['user_id' => Auth::id()]);
        $articles = Lignepanier::with('produit')
            ->where('panier_id', $panier->id)
            ->get();

        return view('panier.index', ['articles' => $articles]);
    }

    // ajouter un produit au panier
    public function store(AddToCartRequest $request): RedirectResponse
    {
        $panier = Panier::firstOrCreate(['user_id' => Auth::id()]);
        $produit = Produit::findOrFail((int) $request->validated('produit_id'));
        $quantite = (int) ($request->validated('quantite') ?? 1);

        $article = Lignepanier::firstOrNew([
            'panier_id' => $panier->id,
            'produit_id' => $produit->id,
        ]);

        $article->quantite = $article->exists ? $article->quantite + $quantite : $quantite;
        $article->prix_unitaire = $produit->prix;
        $article->save();

        return redirect()->route('panier.index');
    }

    public function update(UpdateCartItemRequest $request, Produit $produit): RedirectResponse
    {
        $panier = Panier::where('user_id', Auth::id())->first();
        if (!$panier) {
            return redirect()->route('panier.index');
        }

        $article = Lignepanier::where('panier_id', $panier->id)
            ->where('produit_id', $produit->id)
            ->first();

        if ($article) {
            $article->quantite = (int) $request->validated('quantite');
            $article->save();
        }

        return redirect()->route('panier.index');
    }

    // supprimer un produit du panier
    public function destroy(Produit $produit): RedirectResponse
    {
        $panier = Panier::where('user_id', Auth::id())->first();
        if (!$panier) {
            return redirect()->route('panier.index');
        }

        Lignepanier::where('panier_id', $panier->id)
            ->where('produit_id', $produit->id)
            ->delete();

        return redirect()->route('panier.index');
    }

    // vider le panier
    public function clear(): RedirectResponse
    {
        $panier = Panier::where('user_id', Auth::id())->first();
        if (!$panier) {
            return redirect()->route('panier.index');
        }

        Lignepanier::where('panier_id', $panier->id)->delete();

        return redirect()->route('panier.index');
    }

    // validation du panier (passer la commande)
    public function checkout(): RedirectResponse
    {
        $panier = Panier::where('user_id', Auth::id())->first();
        if (!$panier) {
            return redirect()->route('panier.index');
        }

        DB::transaction(function () use ($panier): void {
            Lignepanier::where('panier_id', $panier->id)->delete();
        });

        return redirect()->route('commandes.index')->with('success', 'Commande validee avec succes.');
    }

}