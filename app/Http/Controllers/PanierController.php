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
    public function __construct(
        private CartService $cartService,
        private OrderService $orderService,
    ) {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $articles = $this->cartService->getCartItems();
        $total = $this->cartService->calculateCartTotal();

        return view('client.panier.index', compact('articles', 'total'));
    }

    public function store(AddToCartRequest $request): RedirectResponse
    {
        try {
            $this->cartService->addToCart(
                (int) $request->validated('produit_id'),
                (int) ($request->validated('quantite') ?? 1),
            );
        } catch (\Exception $e) {
            return redirect()
                ->route('panier.index')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('panier.index')->with('success', 'Produit ajoute au panier.');
    }

    public function update(UpdateCartItemRequest $request, Produit $produit): RedirectResponse
    {
        try {
            $this->cartService->updateQuantity(
                $produit->id,
                (int) $request->validated('quantite'),
            );
        } catch (\Exception $e) {
            return redirect()
                ->route('panier.index')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('panier.index')->with('success', 'Quantite mise a jour.');
    }

    public function destroy(Produit $produit): RedirectResponse
    {
        $this->cartService->removeFromCart($produit->id);

        return redirect()->route('panier.index')->with('success', 'Article retire du panier.');
    }

    public function clear(): RedirectResponse
    {
        $this->cartService->clearCart();

        return redirect()->route('panier.index')->with('success', 'Panier vide.');
    }

    public function checkout(): RedirectResponse
    {
        try {
            $commande = $this->orderService->createOrderFromCart((int) Auth::id());

            return redirect()
                ->route('commandes.show', $commande)
                ->with('success', 'Commande creee avec succes. Vous pouvez proceder au paiement.');
        } catch (\Exception $e) {
            return redirect()
                ->route('panier.index')
                ->with('error', $e->getMessage());
        }
    }
}
