@props(['title', 'description', 'icon' => null])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="text-center py-12">
        <div class="mx-auto w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-4">
            @if($icon)
                {{ $icon }}
            @else
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            @endif
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">
            {{ $title }}
        </h3>
        <p class="text-gray-500 mb-6">
            {{ $description }}
        </p>
        
        @if($slot->isNotEmpty())
            <div>
                {{ $slot }}
            </div>
        @endif
    </div>
</div>
