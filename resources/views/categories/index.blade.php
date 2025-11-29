<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Categories') }}
            </h2>
            <a href="{{ route('categories.create') }}">
                <x-primary-button>
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Category
                </x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Categories Grid -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($categories as $category)
                    <x-category-card :category="$category" />
                @empty
                    <div class="col-span-full">
                        <x-empty-state 
                            title="No Categories Yet"
                            description="Create your first category to organize your inventory items."
                        >
                            <a href="{{ route('categories.create') }}">
                                <x-primary-button>
                                    Create First Category
                                </x-primary-button>
                            </a>
                        </x-empty-state>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>