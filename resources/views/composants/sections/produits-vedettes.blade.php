<section class="py-20 bg-white">

    <div class="max-w-7xl mx-auto px-4">

        {{-- HEADER --}}
        <div class="flex items-end justify-between gap-6 mb-14">

            <div>

                <span class="text-[#D86513] font-semibold tracking-wide uppercase text-sm">

                    Boutique

                </span>

                <h2 class="mt-3 text-4xl font-black text-slate-900">

                    Produits vedettes

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
            @forelse($produitsEnVedette as $item)
                @php
                    $categoryName = $item->categorie?->{$categoryColumn} ?? $item->categorie?->name ?? 'Artisanat';
                @endphp
                @include('composants.cartes.carte-produits', [
                    'title' => $item->nom,
                    'description' => \Illuminate\Support\Str::limit($item->description, 90),
                    'price' => number_format((float) $item->prix, 0, ' ', ' ') . ' FCFA',
                    'category' => ucfirst($categoryName),
                    'badge' => $item->stock > 0 ? 'Disponible' : 'Rupture',
                    'image' => $item->image_url,
                    'url' => route('produits.show', $item),
                ])
            @empty
                <div class="col-span-full text-center py-12 text-slate-400">
                    Aucun produit disponible.
                </div>
            @endforelse
        </div>

    </div>

</section>
