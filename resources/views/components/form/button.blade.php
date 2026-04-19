<button type="{{ $type ?? 'submit' }}" {{ $attributes->merge(['class' => 'btn btn-primary']) }}>
    {{ $slot ?? __('Save') }}
</button>
