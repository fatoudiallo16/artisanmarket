<a
    href="{{ $url ?? '#' }}"
    class="group block bg-white rounded-[32px] overflow-hidden border border-[#EEE4D8] hover:shadow-2xl transition duration-500"
>

    {{-- IMAGE --}}
    <div class="relative overflow-hidden">

        <img
            src="{{ $image }}"
            alt="{{ $title }}"
            class="w-full h-72 object-cover group-hover:scale-110 transition duration-700"
        >

        {{-- BADGE --}}
        @if(isset($badge))

            <div class="absolute top-4 left-4">

                <span class="px-4 py-2 rounded-full bg-[#D86513] text-white text-xs font-bold shadow-lg">

                    {{ $badge }}

                </span>

            </div>

        @endif

        {{-- FAVORIS --}}
        <button
            class="absolute top-4 right-4 w-11 h-11 rounded-full bg-white/90 backdrop-blur flex items-center justify-center shadow-md hover:bg-[#D86513] hover:text-white transition"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                />
            </svg>

        </button>

    </div>

    {{-- CONTENT --}}
    <div class="p-6">

        {{-- CATEGORY --}}
        <span class="text-sm font-medium text-[#D86513]">

            {{ $category }}

        </span>

        {{-- TITLE --}}
        <h3 class="mt-3 text-2xl font-bold text-slate-900 leading-snug">

            {{ $title }}

        </h3>

        {{-- DESCRIPTION --}}
        <p class="mt-3 text-slate-500 leading-relaxed text-sm">

            {{ $description }}

        </p>

        {{-- PRICE + CART --}}
        <div class="mt-6 flex items-center justify-between">

            <div>

                <span class="text-2xl font-black text-slate-900">

                    {{ $price }}

                </span>

            </div>

            {{-- BTN --}}
            <span
                class="w-12 h-12 rounded-2xl bg-[#D86513] hover:bg-[#C45B10] transition text-white flex items-center justify-center shadow-lg shadow-orange-200"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4"
                    />

                    <circle cx="9" cy="19" r="1" />

                    <circle cx="17" cy="19" r="1" />
                </svg>

            </span>

        </div>

    </div>

</a>
