@props(['image' => '', 'title' => '', 'description' => '', 'price' => ''])

<div class="am-product-card rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
    <!-- Image -->
    <div class="relative h-56 bg-gray-200 overflow-hidden">
        <img 
            src="{{ $image }}" 
            alt="{{ $title }}" 
            class="w-full h-full object-cover hover:scale-110 transition-transform duration-300"
        >
    </div>
    
    <!-- Content -->
    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $title }}</h3>
        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $description }}</p>
        
        <!-- Footer -->
        <div class="flex items-center justify-between">
            <span class="text-xl font-bold text-amber-700">{{ $price }}</span>
            <button class="px-4 py-2 bg-amber-700 text-white rounded-md hover:bg-amber-800 transition-colors text-sm font-medium">
                Voir plus
            </button>
        </div>
    </div>
</div>
