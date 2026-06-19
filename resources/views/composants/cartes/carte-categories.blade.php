<a
    href="{{ $url ?? '#' }}"
    class="group block bg-white rounded-[32px] overflow-hidden shadow-sm hover:shadow-2xl transition duration-500"
>

    {{-- IMAGE --}}
    <div class="overflow-hidden">

        <img
            src="{{ $image }}"
            alt="{{ $title }}"
            class="w-full h-64 object-cover group-hover:scale-110 transition duration-700"
        >

    </div>

    {{-- CONTENT --}}
    <div class="p-6">

        <h3 class="text-2xl font-bold text-slate-900">

            {{ $title }}

        </h3>

        <p class="mt-2 text-slate-500 leading-relaxed">

            {{ $description }}

        </p>

    </div>

</a>