<?php

namespace App\Support;

use App\Models\Produit;

class ProduitVisual
{
    /** @return list<string> */
    public static function productImages(): array
    {
        return [
            asset('assets/img/product/product-1.jpg'),
            asset('assets/img/product/product-2.jpg'),
            asset('assets/img/product/product-3.jpg'),
            asset('assets/img/product/product-4.jpg'),
            asset('assets/img/product/product-5.jpg'),
            asset('assets/img/product/product-6.jpg'),
            asset('assets/img/product/product-7.jpg'),
            asset('assets/img/product/produit-8.jpg'),
            asset('assets/img/product/produit-9.jpg'),
            asset('assets/img/product/produit-10.jpg'),
            asset('assets/img/product/produit-11.jpg'),
            // Images Unsplash par catégorie comme fallback supplémentaire
            'https://images.unsplash.com/photo-1617038260897-41a1f14a8ca0?q=80&w=600&auto=format&fit=crop', // Bijoux
            'https://images.unsplash.com/photo-1544816155-12df9643f363?q=80&w=600&auto=format&fit=crop', // Tissus
            'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?q=80&w=600&auto=format&fit=crop', // Poterie
            'https://images.unsplash.com/photo-1606744824163-985d376605aa?q=80&w=600&auto=format&fit=crop', // Bois
            'https://images.unsplash.com/photo-1524289286702-f07229da36f5?q=80&w=600&auto=format&fit=crop', // Cuir
            'https://images.unsplash.com/photo-1511192336575-5a79af67a629?q=80&w=600&auto=format&fit=crop', // Instruments
            'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?q=80&w=600&auto=format&fit=crop', // Maroquinerie
            'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?q=80&w=600&auto=format&fit=crop', // Art mural
            'https://images.unsplash.com/photo-1595181980833-28b7e28b8431?q=80&w=600&auto=format&fit=crop', // Vannerie
            'https://images.unsplash.com/photo-1608248597481-496100c80836?q=80&w=600&auto=format&fit=crop', // Cosmétiques
        ];
    }

    public static function imageUrl(Produit|int $produitOrId, ?int $loopIndex = null): string
    {
        if ($produitOrId instanceof Produit) {
            if ($produitOrId->image) {
                return asset('storage/' . $produitOrId->image);
            }

            return self::fallbackImageUrl($produitOrId, $loopIndex);
        }

        $images = self::productImages();
        $index = $loopIndex ?? $produitOrId;

        return $images[$index % count($images)];
    }

    public static function fallbackImageUrl(Produit|int $produitOrId, ?int $loopIndex = null): string
    {
        $images = self::productImages();
        
        // Si c'est un objet Produit, essayer d'utiliser une image basée sur la catégorie
        if ($produitOrId instanceof Produit) {
            $categoryName = $produitOrId->categorie?->name ?? '';
            $categoryImage = self::getImageForCategory($categoryName);
            if ($categoryImage) {
                return $categoryImage;
            }
        }
        
        // Fallback cyclique basé sur l'ID
        $index = $loopIndex ?? (is_int($produitOrId) ? $produitOrId : $produitOrId->id);
        return $images[$index % count($images)];
    }

    private static function getImageForCategory(?string $category): ?string
    {
        $slug = strtolower(trim((string) $category));
        
        $categoryImages = [
            'bijou' => 'https://images.unsplash.com/photo-1617038260897-41a1f14a8ca0?q=80&w=600&auto=format&fit=crop',
            'tissu' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?q=80&w=600&auto=format&fit=crop',
            'bogolan' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?q=80&w=600&auto=format&fit=crop',
            'textile' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?q=80&w=600&auto=format&fit=crop',
            'poterie' => 'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?q=80&w=600&auto=format&fit=crop',
            'céram' => 'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?q=80&w=600&auto=format&fit=crop',
            'ceram' => 'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?q=80&w=600&auto=format&fit=crop',
            'cuir' => 'https://images.unsplash.com/photo-1524289286702-f07229da36f5?q=80&w=600&auto=format&fit=crop',
        ];
        
        foreach ($categoryImages as $key => $imageUrl) {
            if (str_contains($slug, $key)) {
                return $imageUrl;
            }
        }
        
        return null;
    }

    /** @return array{slug: string, label: string, class: string, icon: string} */
    public static function forProduit(Produit $produit): array
    {
        $name = $produit->categorie?->name ?? '';

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
