<div
    class="flex flex-col gap-2 items-center justify-center"
    x-ignore
    ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('qr','lara-zeus/qr') }}"
    ax-load
    x-data="qrPlugin({
        state: '{{ $statePath }}',
    })"
>
    <div class="flex flex-col justify-center items-center" x-ref="qr">
        {{ \LaraZeus\Qr\Facades\Qr::output($data,$options) }}
    </div>

    @if($downloadable)
        <div class="flex items-center gap-4">
            <x-filament::button
                    :tooltip="__('Download as a PNG')"
                    color="info"
                    size="sm"
                    icon="heroicon-o-arrow-down-tray"
                    @click="download('{{ $statePath }}','png');"
            >
                {{ __('png') }}
            </x-filament::button>
            <x-filament::button
                    :tooltip="__('Download as an SVG')"
                    color="info"
                    size="sm"
                    icon="heroicon-o-arrow-down-tray"
                    @click="download('{{ $statePath }}','svg');"
            >
                {{ __('svg') }}
            </x-filament::button>
        </div>
    @endif
</div>
