<?php

namespace App\Services;

use App\Models\Annonce;
use Illuminate\Support\Facades\Storage;

class AnnonceService
{
    /**
     * Créer une annonce
     */
    public function create(int $userId, array $data): Annonce
    {
        $annonce = new Annonce();
        $annonce->titre = $data['titre'];
        $annonce->contenu = $data['contenu'];
        $annonce->user_id = $userId;

        if (isset($data['image']) && $data['image']) {
            $annonce->image = $data['image']->store('annonces', 'public');
        }

        $annonce->save();

        return $annonce;
    }

    /**
     * Mettre à jour une annonce
     */
    public function update(Annonce $annonce, array $data): Annonce
    {
        $annonce->titre = $data['titre'] ?? $annonce->titre;
        $annonce->contenu = $data['contenu'] ?? $annonce->contenu;

        if (isset($data['image']) && $data['image']) {
            // Supprimer l'ancienne image
            if ($annonce->image) {
                Storage::disk('public')->delete($annonce->image);
            }
            $annonce->image = $data['image']->store('annonces', 'public');
        }

        $annonce->save();

        return $annonce;
    }

    /**
     * Supprimer une annonce
     */
    public function delete(Annonce $annonce): bool
    {
        // Supprimer l'image
        if ($annonce->image) {
            Storage::disk('public')->delete($annonce->image);
        }

        return $annonce->delete();
    }

    /**
     * Récupérer les annonces avec pagination
     */
    public function getPaginated(int $perPage = 10)
    {
        return Annonce::with('user')->latest()->paginate($perPage);
    }

    /**
     * Récupérer une annonce spécifique
     */
    public function getById(int $id): Annonce
    {
        return Annonce::with('user')->findOrFail($id);
    }
}
