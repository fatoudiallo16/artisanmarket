<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategorieController extends Controller
{
    /**
     * Afficher la liste des catégories
     */
    public function index(): JsonResponse
    {
        return response()->json(
            Categorie::withCount('produits')->latest()->paginate(20)
        );
    }

    /**
     * Afficher une catégorie spécifique
     */
    public function show(Categorie $categorie): JsonResponse
    {
        return response()->json(
            $categorie->load('produits')
        );
    }

    /**
     * Créer une nouvelle catégorie
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nom_categorie' => ['required', 'string', 'max:255', 'unique:categories,nom_categorie'],
            'description' => ['nullable', 'string'],
        ]);

        $categorie = Categorie::create($data);

        return response()->json([
            'message' => 'Catégorie créée avec succès.',
            'categorie' => $categorie,
        ], 201);
    }

    /**
     * Mettre à jour une catégorie
     */
    public function update(Request $request, Categorie $categorie): JsonResponse
    {
        $data = $request->validate([
            'nom_categorie' => ['required', 'string', 'max:255', 'unique:categories,nom_categorie,'.$categorie->id],
            'description' => ['nullable', 'string'],
        ]);

        $categorie->update($data);

        return response()->json([
            'message' => 'Catégorie mise à jour.',
            'categorie' => $categorie->fresh(),
        ]);
    }

    /**
     * Supprimer une catégorie
     */
    public function destroy(Categorie $categorie): JsonResponse
    {
        $categorie->delete();

        return response()->json([
            'message' => 'Catégorie supprimée.',
        ]);
    }
}
