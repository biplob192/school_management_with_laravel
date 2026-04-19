@props([
    'label' => '',
    'name',
    'options' => [],
    'selected' => [],
    'required' => false,
])

<div class="mb-3 {{ $attributes['class'] ?? '' }}">
    @if ($label)
        <label class="form-label d-block">
            {{ $label }} @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    @foreach ($options as $value => $optionLabel)
        <div class="form-check form-check-inline">
            <input type="checkbox" name="{{ $name }}[]" id="{{ $name . '_' . $value }}" value="{{ $value }}" class="form-check-input" {{ in_array($value, $selected) ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ $name . '_' . $value }}">
                {{ $optionLabel }}
            </label>
        </div>
    @endforeach
</div>
