<section class="py-16 bg-[#FAF7F2]">

    <div class="max-w-7xl mx-auto px-4">

        {{-- HEADER --}}
        <div class="flex items-end justify-between gap-6 mb-14">

            <div>

                <span class="text-[#D86513] font-semibold tracking-wide uppercase text-sm">

                    Explorer

                </span>

                <h2 class="mt-3 text-4xl font-black text-slate-900">

                    Catégories populaires

                </h2>

            </div>

            <a
                href="{{ route('produits.index') }}"
                class="hidden md:flex items-center gap-2 text-[#D86513] font-semibold hover:gap-3 transition-all"
            >
                Voir tout →
            </a>

        </div>

        {{-- GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($categories as $category)
                @php
                    $categoryName = $category->{$categoryColumn} ?? $category->name ?? 'Catégorie';
                    $slug = strtolower(\Illuminate\Support\Str::slug($categoryName));
                    $assetMap = [
                        'mode' => 'mode.jpg',
                        'decoration' => 'deco.jpg',
                        'decorations' => 'deco.jpg',
                        'bijoux' => 'bijoux.jpg',
                        'poterie' => 'poterie.jpg',
                    ];
                    $mappedImage = $assetMap[$slug] ?? 'deco.jpg';
                    $imageUrl = $category->image ? asset('storage/' . $category->image) : asset('images/categories/' . $mappedImage);
                @endphp
                @include('composants.cartes.carte-categories', [
                    'title' => ucfirst($categoryName),
                    'description' => $category->description ?? 'Découvrez notre collection d\'articles artisanaux.',
                    'image' => $imageUrl,
                    'url' => route('produits.index', ['categorie' => $categoryName])
                ])
            @empty
                <div class="col-span-full text-center py-12 text-slate-400">
                    Aucune catégorie disponible.
                </div>
            @endforelse
        </div>

    </div>

</section>
