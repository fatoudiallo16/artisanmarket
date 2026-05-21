<?php

namespace App\Support;

use App\Models\Produit;

class ProduitVisual
{
    /** @return array{slug: string, label: string, class: string, icon: string} */
    public static function forProduit(Produit $produit): array
    {
        $name = $produit->categorie?->nom
            ?? $produit->categorie?->nom_categorie
            ?? '';

        return self::forCategory($name);
    }

    /** @return array{slug: string, label: string, class: string, icon: string} */
    public static function forCategory(?string $category): array
    {
        $slug = strtolower(trim((string) $category));

        $themes = [
            ['keys' => ['bijou'], 'slug' => 'bijoux', 'label' => 'Bijoux', 'class' => 'am-visual-bijoux', 'icon' => 'gem'],
            ['keys' => ['tissu', 'bogolan', 'textile'], 'slug' => 'tissus', 'label' => 'Tissus', 'class' => 'am-visual-tissus', 'icon' => 'fabric'],
            ['keys' => ['poterie', 'céram', 'ceram'], 'slug' => 'poterie', 'label' => 'Poterie', 'class' => 'am-visual-poterie', 'icon' => 'pot'],
            ['keys' => ['bois', 'sculpt'], 'slug' => 'bois', 'label' => 'Sculpture', 'class' => 'am-visual-bois', 'icon' => 'mask'],
            ['keys' => ['cuir'], 'slug' => 'cuir', 'label' => 'Cuir', 'class' => 'am-visual-cuir', 'icon' => 'leather'],
            ['keys' => ['instrument', 'musique'], 'slug' => 'instruments', 'label' => 'Instruments', 'class' => 'am-visual-instruments', 'icon' => 'music'],
            ['keys' => ['maroqu'], 'slug' => 'maroquinerie', 'label' => 'Maroquinerie', 'class' => 'am-visual-maro', 'icon' => 'bag'],
            ['keys' => ['mural', 'art'], 'slug' => 'mural', 'label' => 'Art mural', 'class' => 'am-visual-mural', 'icon' => 'frame'],
            ['keys' => ['vannerie', 'panier'], 'slug' => 'vannerie', 'label' => 'Vannerie', 'class' => 'am-visual-vannerie', 'icon' => 'basket'],
            ['keys' => ['cosmet', 'savon', 'beaute'], 'slug' => 'cosmetiques', 'label' => 'Cosmétiques', 'class' => 'am-visual-cosmetiques', 'icon' => 'leaf'],
        ];

        foreach ($themes as $theme) {
            foreach ($theme['keys'] as $key) {
                if (str_contains($slug, $key)) {
                    return [
                        'slug' => $theme['slug'],
                        'label' => $theme['label'],
                        'class' => $theme['class'],
                        'icon' => $theme['icon'],
                    ];
                }
            }
        }

        return [
            'slug' => 'artisanat',
            'label' => $category ? ucfirst($category) : 'Artisanat',
            'class' => 'am-visual-default',
            'icon' => 'craft',
        ];
    }

    public static function placeholderIndex(int $id, string $slug): int
    {
        $variants = match ($slug) {
            'bijoux' => [0, 1, 2],
            'tissus' => [3, 4, 5],
            'poterie' => [6, 7, 8],
            'bois' => [9, 10, 11],
            default => [0, 3, 6, 9],
        };

        return $variants[$id % count($variants)];
    }
}
