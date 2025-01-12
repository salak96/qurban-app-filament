<div class="alert alert-info">
    {{ $slot }}
</div>

@once
    @push('filament-styles')
        @once
            @livewireStyles
        @endonce
        @livewireStyles
    @endpush
    @push('filament-scripts')
        @once
            @livewireScripts
        @endonce
        @livewireScripts
    @endpush
@endonce
