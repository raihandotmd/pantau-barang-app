@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-pantau-medium focus:ring-pantau-medium rounded-md shadow-sm']) }}>
