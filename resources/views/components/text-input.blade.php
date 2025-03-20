@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-brand-yellow focus:ring-brand-yellow rounded-md shadow-sm']) }}>
