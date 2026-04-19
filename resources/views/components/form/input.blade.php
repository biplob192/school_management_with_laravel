@props([
    'type' => 'text',
    'label' => '', // Main label
    'checkboxLabel' => '', // Label beside the checkbox
    'required' => false,
    'error' => false,
    'value' => old($attributes['name'] ?? ''),
    'options' => [],
    'checked' => false,
    'placeholder' => 'Select an option',
    'showAsteriskId' => null,
])

<div class="mb-3 {{ $attributes['class'] ?? '' }}">
    @if ($label)
        <label class="form-label" for="{{ $attributes['id'] ?? ($attributes['name'] ?? '') }}">
            {{ $label }}
            @if ($required || $showAsteriskId)
                <span class="text-danger" id="{{ $showAsteriskId ?? ($attributes['name'] ?? '') . '-required-marker' }}">*</span>
            @endif
        </label>
    @endif


    @if ($type === 'select')
        {{-- Only single-select support --}}
        <select {{ $attributes->merge(['class' => 'form-control form-select']) }} @if ($required) required @endif>
            <option value="" disabled {{ $value === '' || $value === null ? 'selected' : '' }}>
                {{ $placeholder }}
            </option>

            @foreach ($options as $key => $option)
                <option value="{{ $key }}" {{ $key == $value ? 'selected' : '' }}>
                    {{ $option }}
                </option>
            @endforeach
        </select>
    @elseif($type === 'checkbox')
        {{-- Single checkbox only --}}
        @php
            $inputId = $attributes['id'] ?? ($attributes['name'] ?? uniqid('checkbox_'));
        @endphp

        <div class="form-check mt-2">
            <input id="{{ $inputId }}" type="checkbox" value="{{ $value ?? 1 }}" {{ $attributes->merge(['class' => 'form-check-input']) }} {{ $checked ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ $attributes['id'] ?? ($attributes['name'] ?? '') }}">
                {{ $checkboxLabel ?: $label }}
            </label>
        </div>
    @else
        {{-- Default input types (text, number, etc.) --}}
        <input type="{{ $type }}" value="{{ $value }}" {{ $attributes->merge(['class' => 'form-control']) }} @if ($required) required @endif />
    @endif

    @if ($error)
        <div class="invalid-feedback d-block text-danger">
            {{ $error }}
        </div>
    @endif
</div>
