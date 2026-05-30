<?php

// app/Http/Controllers/AnnonceController.php
namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Services\AnnonceService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    public function __construct(private AnnonceService $annonceService)
    {
    }

    public function index(): View
    {
        $annonces = $this->annonceService->getPaginated(10);

        return view('annonces.index', compact('annonces'));
    }

    public function create(): View
    {
        $this->authorize('create', Annonce::class);

        return view('annonces.create');
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

        return redirect()->route('annonces.index')->with('success', 'Annonce publiée avec succès.');
    }

    public function show(Annonce $annonce): View
    {
        return view('annonces.show', compact('annonce'));
    }

    public function edit(Annonce $annonce): View
    {
        $this->authorize('update', $annonce);
        return view('annonces.edit', compact('annonce'));
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

        return redirect()->route('annonces.show', $annonce)->with('success', 'Annonce mise à jour.');
    }

    public function destroy(Annonce $annonce): RedirectResponse
    {
        $this->authorize('delete', $annonce);

        $this->annonceService->delete($annonce);

        return redirect()->route('annonces.index')->with('success', 'Annonce supprimée.');
    }
}
