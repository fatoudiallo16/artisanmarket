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
                    $categoryName = $category->name ?? 'Catégorie';
                    $slug = strtolower(\Illuminate\Support\Str::slug($categoryName));
                    $unsplashMap = [
                        'bijoux' => 'https://images.unsplash.com/photo-1617038260897-41a1f14a8ca0?q=80&w=600&auto=format&fit=crop',
                        'tissus' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?q=80&w=600&auto=format&fit=crop',
                        'poterie' => 'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?q=80&w=600&auto=format&fit=crop',
                        'pot-en-terre-cuite' => 'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?q=80&w=600&auto=format&fit=crop',
                        'sculpture-bois' => 'https://images.unsplash.com/photo-1606744824163-985d376605aa?q=80&w=600&auto=format&fit=crop',
                        'cuir' => 'https://images.unsplash.com/photo-1524289286702-f07229da36f5?q=80&w=600&auto=format&fit=crop',
                        'instruments' => 'https://images.unsplash.com/photo-1511192336575-5a79af67a629?q=80&w=600&auto=format&fit=crop',
                        'maroquinerie' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?q=80&w=600&auto=format&fit=crop',
                        'art-mural' => 'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?q=80&w=600&auto=format&fit=crop',
                        'vannerie' => 'https://images.unsplash.com/photo-1595181980833-28b7e28b8431?q=80&w=600&auto=format&fit=crop',
                        'cosmetiques' => 'https://images.unsplash.com/photo-1608248597481-496100c80836?q=80&w=600&auto=format&fit=crop',
                        'mode' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=600&auto=format&fit=crop',
                        'decoration' => 'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?q=80&w=600&auto=format&fit=crop',
                    ];
                    $imageUrl = $category->image 
                        ? asset('storage/' . $category->image) 
                        : ($unsplashMap[$slug] ?? 'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?q=80&w=600');
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
