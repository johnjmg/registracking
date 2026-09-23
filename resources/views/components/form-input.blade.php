@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => null,
    'required' => false,
    'placeholder' => '',
    'help' => null,
    'min' => null,
    'max' => null,
    'step' => null,
])

<div class="mb-4">
    @if ($label)
        <label for="{{ $name }}" class="block font-medium mb-1 text-gray-700">
            {{ $label }}
            @if ($required)
                <span class="text-red-500" aria-hidden="true">*</span>
            @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        @if ($required) required @endif
        @if ($min !== null) min="{{ $min }}" @endif
        @if ($max !== null) max="{{ $max }}" @endif
        @if ($step !== null) step="{{ $step }}" @endif
        {{ $attributes->merge(['class' => 'w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500']) }}
        @error($name) aria-invalid="true" aria-describedby="{{ $name }}-error" @enderror
    >

    @if ($help)
        <p class="text-gray-500 text-sm mt-1">{{ $help }}</p>
    @endif

    @error($name)
        <p id="{{ $name }}-error" class="text-red-600 text-sm mt-1" role="alert">
            {{ $message }}
        </p>
    @enderror
</div>