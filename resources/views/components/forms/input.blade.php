@props(['type' => 'text', 'label', 'name', 'value', 'placeholder', 'required'])

<div class="mb-6">
    <label for="{{ $name }}"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</label>
    <input type="{{ $type }}" wire:model.defer="{{ $name }}" id="{{ $name }}"
        name="{{ $name }}" value="{{ $value }}"
        class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        placeholder="{{ $placeholder }}" @if ($required) required @endif>
    @error($name)
        <span class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span>
    @enderror
</div>