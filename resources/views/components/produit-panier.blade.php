<div
    x-data="{
        added: false,
        liked: false
    }"

    class="bg-white rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition duration-300 group"
>

    <!-- IMAGE -->

    <div class="relative overflow-hidden">

        <img
            src="{{ $image }}"
            class="w-full h-72 object-cover group-hover:scale-110 transition duration-500"
        >

        <!-- BADGE -->

        <div class="absolute top-4 left-4">

            <span class="bg-orange-500 text-white text-xs px-3 py-1 rounded-full">
                Nouveau
            </span>

        </div>

        <!-- FAVORIS -->

        <button
            @click="liked = !liked"
            class="absolute top-4 right-4 bg-white p-2 rounded-full shadow"
        >

            <span
                x-text="liked ? '❤️' : '🤍'"
                class="text-xl"
            ></span>

        </button>

    </div>

    <!-- CONTENU -->

    <div class="p-5">

        <h2 class="text-xl font-bold">
            {{ $title }}
        </h2>

        <p class="mt-2 text-gray-500">
            {{ $description }}
        </p>

        <!-- FOOTER -->

        <div class="mt-5 flex items-center justify-between">

            <span class="text-2xl font-bold text-orange-500">
                {{ $price }}
            </span>

            <!-- BUTTON -->

            <button
                @click="added = !added"

                :class="added
                    ? 'bg-green-600'
                    : 'bg-orange-500'
                "

                class="text-white px-5 py-2 rounded-xl transition"
            >

                <span
                    x-text="added
                        ? 'Ajouté ✓'
                        : 'Ajouter'"
                ></span>

            </button>

        </div>

    </div>

</div>