<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use App\Models\User;
use App\Services\ProduitImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProduitController extends Controller
{
    public function __construct(
        private readonly ProduitImageService $images,
    ) {}

    public function index(Request $request): View
    {
        $query = Produit::with(['vendeur', 'categorie']);

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where(function ($builder) use ($search) {
                $builder->where('nom', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('categorie')) {
            $category = $request->string('categorie')->lower()->toString();
            $query->whereHas('categorie', function ($builder) use ($category) {
                if (is_numeric($category)) {
                    $builder->where('id', (int) $category);
                } else {
                    $builder->whereRaw("LOWER(name) like ?", ["%{$category}%"]);
                }
            });
        }

        if ($request->filled('boutique')) {
            $query->where('vendeur_id', (int) $request->input('boutique'));
        }

        if ($request->filled('min_price')) {
            $query->where('prix', '>=', (float) $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('prix', '<=', (float) $request->input('max_price'));
        }

        match ($request->input('sort')) {
            'prix_asc' => $query->orderBy('prix'),
            'prix_desc' => $query->orderByDesc('prix'),
            'nouveautes' => $query->latest(),
            default => $query->latest(),
        };

        $produits = $query->paginate(12)->withQueryString();
        $categories = Categorie::query()
            ->withCount('produits')
            ->orderByDesc('produits_count')
            ->limit(7)
            ->get();

        return view('public.produits.index', compact('produits', 'categories'));
    }

    public function byCategorie(Categorie $categorie): View
    {
        $produits = Produit::with(['vendeur', 'categorie'])
            ->where('categorie_id', $categorie->id)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Categorie::query()
            ->withCount('produits')
            ->orderByDesc('produits_count')
            ->limit(7)
            ->get();

        return view('public.produits.index', compact('produits', 'categories', 'categorie'));
    }

    public function show(Produit $produit): View
    {
        $produit->load(['vendeur.user', 'categorie']);

        $related = Produit::with(['vendeur', 'categorie'])
            ->where('categorie_id', $produit->categorie_id)
            ->where('id', '!=', $produit->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // Ordre catalogue = plus récent en premier (latest)
        $previous = Produit::where('id', '>', $produit->id)->orderBy('id')->first();
        $next = Produit::where('id', '<', $produit->id)->orderByDesc('id')->first();

        return view('public.produits.show', compact('produit', 'related', 'previous', 'next'));
    }

    public function create(): View
    {
        $this->authorize('create', Produit::class);
        $this->ensureCanManageProducts();

        /** @var User $user */
        $user = Auth::user();

        return view('vendeur.produits.create', [
            'categories' => Categorie::orderBy('name')->get(),
            'vendeurs' => $user->hasRole('admin') ? \App\Models\Vendeur::where('statut', 'approuve')->orderBy('nom_boutique')->get() : collect(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Produit::class);
        $this->ensureCanManageProducts();

        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'prix' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'categorie_id' => ['required', 'exists:categories,id'],
            'vendeur_id' => ['nullable', 'exists:vendeurs,id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
        ]);

        $vendeurId = $this->resolveVendeurId($request);
        $data['vendeur_id'] = $vendeurId;

        if ($request->hasFile('image')) {
            $data['image'] = $this->images->store($request->file('image'), $vendeurId);
        }

        $produit = Produit::create($data);

        /** @var User $user */
        $user = Auth::user();
        $redirectRoute = $user->hasRole('admin') ? 'admin.dashboard' : 'vendeur.dashboard';

        return redirect()
            ->route($redirectRoute)
            ->with('success', 'Produit créé avec succès.');
    }

    public function edit(Produit $produit): View
    {
        $this->authorize('update', $produit);

        return view('vendeur.produits.edit', [
            'produit' => $produit,
            'categories' => Categorie::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Produit $produit): RedirectResponse
    {
        $this->authorize('update', $produit);

        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'prix' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'categorie_id' => ['required', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
            'remove_image' => ['nullable', 'boolean'],
        ]);

        if ($request->boolean('remove_image')) {
            $this->images->delete($produit->image);
            $data['image'] = null;
        } elseif ($request->hasFile('image')) {
            $data['image'] = $this->images->replace($produit, $request->file('image'));
        }

        unset($data['remove_image']);
        $produit->update($data);

        return redirect()->route('produits.show', $produit)->with('success', 'Produit mis à jour.');
    }

    public function destroy(Produit $produit): RedirectResponse
    {
        $this->authorize('delete', $produit);

        $this->images->delete($produit->image);
        $produit->delete();

        return redirect()->route('produits.index')->with('success', 'Produit supprimé.');
    }

    private function resolveVendeurId(Request $request): int
    {
        $user = Auth::user();

        if ($user->hasRole('admin') && $request->filled('vendeur_id')) {
            return (int) $request->input('vendeur_id');
        }

        if ($user->vendeur) {
            return (int) $user->vendeur->id;
        }

        abort(403, 'Aucun profil vendeur associé à ce compte.');
    }

    private function ensureCanManageProducts(): void
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return;
        }

        if (!$user->hasRole('vendeur')) {
            abort(403, 'Seuls les vendeurs et administrateurs peuvent gérer des produits.');
        }

        $vendeur = $user->vendeur;

        if (!$vendeur) {
            abort(403, 'Aucune boutique associée à votre compte. Contactez l\'administrateur.');
        }

        if (!$vendeur->isActive()) {
            abort(403, 'Votre boutique doit être approuvée par un administrateur avant d\'ajouter des produits.');
        }
    }
}
