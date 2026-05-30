<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:255',
        'image' => 'nullable|image'
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {

        $imagePath = $request
            ->file('image')
            ->store('categories', 'public');
    }
    

    Categorie::create([
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'description' => $request->description,
        'image' => $imagePath,
        'status' => true
    ]);

    return redirect()
        ->route('categories.index')
        ->with('success', 'Catégorie créée.');
}

    /**
     * Mettre à jour une catégorie
     */
    public function update(Request $request, Categorie $categorie)
{
    $data = $request->validate([
        'name' => 'required|max:255',
        'description' => 'nullable',
        'image' => 'nullable|image'
    ]);

    if ($request->hasFile('image')) {

        $data['image'] = $request
            ->file('image')
            ->store('categories', 'public');
    }

    $data['status'] = $request->has('status');

    $categorie->update($data);

    return redirect()
        ->route('categories.index')
        ->with('success', 'Catégorie mise à jour.');
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
    public function create()
   {
    return view('admin.categories.create');
    }
    public function edit(Categorie $categorie)
{
    return view('admin.categories.edit', compact('categorie'));
}
}
