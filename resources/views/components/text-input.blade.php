@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-700  text-gray-700 focus:border-indigo-700 focus:ring-indigo-700  rounded-md shadow-sm']) !!}>
