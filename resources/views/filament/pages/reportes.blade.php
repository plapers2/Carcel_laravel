<x-filament-panels::page>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <form wire:submit.prevent="submit" class="space-y-4">
        {{ $this->form }}

        {{-- <div class="flex gap-4">
            <x-filament::button type="submit">
                Ver datos
            </x-filament::button>

            <x-filament::button wire:click="exportPDF" color="danger">
                PDF
            </x-filament::button>

            <x-filament::button wire:click="exportExcel" color="success">
                Excel
            </x-filament::button>
        </div> --}}
    </form>
</x-filament-panels::page>
