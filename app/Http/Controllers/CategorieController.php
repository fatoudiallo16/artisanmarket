<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategorieController extends Controller
{
    public function index(Request $request): JsonResponse|View
    {
        $categories = Categorie::withCount('produits')->latest()->paginate(20);

        if ($request->expectsJson()) {
            return response()->json($categories);
        }

        return view('admin.categories.index', compact('categories'));
    }

    public function show(Request $request, Categorie $categorie): JsonResponse|View
    {
        $categorie->loadCount('produits');

        if ($request->expectsJson()) {
            return response()->json($categorie->load('produits'));
        }

        return view('admin.categories.show', [
            'categorie' => $categorie,
            'category' => $categorie,
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image'],
            'status' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['status'] = $request->boolean('status');

        Categorie::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Categorie creee.');
    }

    public function edit(Categorie $categorie): View
    {
        return view('admin.categories.edit', [
            'categorie' => $categorie,
            'category' => $categorie,
        ]);
    }

    public function update(Request $request, Categorie $categorie): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image'],
            'status' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        if ($data['name'] !== $categorie->name) {
            $data['slug'] = $this->uniqueSlug($data['name'], $categorie->id);
        }

        $data['status'] = $request->boolean('status');
        $categorie->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Categorie mise a jour.');
    }

    public function destroy(Request $request, Categorie $categorie): JsonResponse|RedirectResponse
    {
        $categorie->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Categorie supprimee.',
            ]);
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Categorie supprimee.');
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: Str::random(8);
        $slug = $base;
        $suffix = 2;

        while (
            Categorie::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }
}
