<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\Produit;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PanierController extends Controller
{
    public function __construct(private CartService $cartService, private OrderService $orderService)
    {
        $this->middleware('auth');
    }
    
    // afficher le panier de l'utilisateur
    public function index(): View
    {
        $articles = $this->cartService->getCartItems(Auth::id());
        $total = $this->cartService->calculateCartTotal(Auth::id());

        return view('public.panier.index', ['articles' => $articles, 'total' => $total]);
    }

    public function commande(): View
    {
        $articles = $this->cartService->getCartItems(Auth::id());
        $total = $this->cartService->calculateCartTotal(Auth::id());

        return view('public.commande.index', ['articles' => $articles, 'total' => $total]);
    }

    // ajouter un produit au panier
    public function store(AddToCartRequest $request): RedirectResponse
    {
        $produitId = (int) $request->validated('produit_id');
        $quantite = (int) ($request->validated('quantite') ?? 1);

        try {
            $produit = Produit::findOrFail($produitId);
            $this->cartService->addToCart($produitId, $quantite, Auth::id());

            return redirect()->back()->with('cart_added', [
                'nom' => $produit->nom,
                'quantite' => $quantite,
                'cart_count' => $this->cartService->getCartCount(Auth::id()),
                'cart_total' => $this->cartService->calculateCartTotal(Auth::id()),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(UpdateCartItemRequest $request, $produitId): RedirectResponse
    {
        $quantite = (int) $request->validated('quantite');

        try {
            $this->cartService->updateQuantity($produitId, $quantite, Auth::id());
            return redirect()->route('panier.index')->with('success', 'Quantité mise à jour.');
        } catch (\Exception $e) {
            return redirect()->route('panier.index')->with('error', $e->getMessage());
        }
    }

    // supprimer un produit du panier
    public function destroy($produitId): RedirectResponse
    {
        $this->cartService->removeFromCart($produitId, Auth::id());
        return redirect()->route('panier.index')->with('success', 'Produit supprimé du panier.');
    }

    // vider le panier
    public function clear(): RedirectResponse
    {
        $this->cartService->clearCart(Auth::id());
        return redirect()->route('panier.index')->with('success', 'Panier vidé.');
    }

    // validation du panier (passer la commande)
    public function checkout(): RedirectResponse
    {
        if ($this->cartService->getCartItems(Auth::id())->isEmpty()) {
            return redirect()->route('panier.index')->with('error', 'Votre panier est vide.');
        }

        try {
            $commande = $this->orderService->createOrderFromCart(Auth::id());

            return redirect()
                ->route('commandes.show', $commande)
                ->with('success', 'Commande créée. Procédez au paiement.');
        } catch (\Exception $e) {
            return redirect()->route('panier.index')->with('error', $e->getMessage());
        }
    }

}
