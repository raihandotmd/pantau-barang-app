<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-pantau-medium border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pantau-dark focus:bg-pantau-dark active:bg-pantau-dark focus:outline-none focus:ring-2 focus:ring-pantau-medium focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
