<?php

// app/Http/Controllers/AnnonceController.php
namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Services\AnnonceService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    public function __construct(private AnnonceService $annonceService)
    {
    }

    public function index(): RedirectResponse
    {
        return redirect()->route('welcome');
    }

    public function create(): RedirectResponse
    {
        $this->authorize('create', Annonce::class);

        return redirect()->route('admin.dashboard');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Annonce::class);

        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $this->annonceService->create(Auth::id(), $request->only('titre', 'contenu', 'image'));

        return redirect()->route('admin.dashboard')->with('success', 'Annonce publiée avec succès.');
    }

    public function show(Annonce $annonce): RedirectResponse
    {
        return redirect()->route('welcome');
    }

    public function edit(Annonce $annonce): RedirectResponse
    {
        $this->authorize('update', $annonce);
        return redirect()->route('admin.dashboard');
    }

    public function update(Request $request, Annonce $annonce): RedirectResponse
    {
        $this->authorize('update', $annonce);

        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $this->annonceService->update($annonce, $request->only('titre', 'contenu', 'image'));

        return redirect()->route('admin.dashboard')->with('success', 'Annonce mise à jour.');
    }

    public function destroy(Annonce $annonce): RedirectResponse
    {
        $this->authorize('delete', $annonce);

        $this->annonceService->delete($annonce);

        return redirect()->route('annonces.index')->with('success', 'Annonce supprimée.');
    }
}
