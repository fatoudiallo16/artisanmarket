<?php

namespace App\Services;

use App\Models\Produit;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProduitImageService
{
    public function store(UploadedFile $file, int $vendeurId): string
    {
        $directory = "produits/vendeur_{$vendeurId}";
        $filename = Str::ulid() . '.' . $file->getClientOriginalExtension();

        return $file->storeAs($directory, $filename, 'public');
    }

    public function delete(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }

    public function replace(Produit $produit, UploadedFile $file): string
    {
        $this->delete($produit->image);

        return $this->store($file, (int) $produit->vendeur_id);
    }
}
