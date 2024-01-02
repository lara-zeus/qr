<div
    class="flex flex-col gap-2 items-center justify-center"
    x-ignore
    ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('qr','lara-zeus/qr') }}"
    ax-load
    x-data="qrPlugin({
        state: '{{ $statePath }}',
    })"
>
    <div class="{{ $statePath }} flex flex-col justify-center items-center">
        {{ \LaraZeus\Qr\Facades\Qr::output($data,$options) }}
    </div>

    @if($downloadable)
        <x-filament::button
            color="info"
            size="sm"
            icon="heroicon-o-arrow-down-tray"
            @click="download('{{ $statePath }}');"
        >
            {{ __('Download') }}
        </x-filament::button>
    @endif
</div>
