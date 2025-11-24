<div x-data="{
    category: null,
    action: '',
    init() {
        this.$watch('category', value => {
            if (value) {
                this.action = '/categories/' + value.id;
            }
        });
    }
}"
x-on:open-modal.window="if ($event.detail.name === 'edit-category') { category = $event.detail.category; }"
>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Edit Kategori</h2>
        <form x-bind:action="action" method="POST" class="space-y-6" x-show="category">
        @csrf
        @method('PUT')

        <!-- Category Name -->
        <div>
            <x-input-label for="edit_category_name" :value="__('Nama Kategori')" />
            <x-text-input id="edit_category_name" class="block mt-1 w-full" type="text" name="name" x-model="category.name" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6 gap-3">
            <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                Batal
            </button>
            <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700">
                Simpan Perubahan
            </button>
        </div>
    </form>
    </div>
</div>
