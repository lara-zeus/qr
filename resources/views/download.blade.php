<div
    class="flex flex-col gap-2 items-center justify-center"
    x-ignore
    x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('qr','lara-zeus/qr') }}"
    x-load
    x-data="qrPlugin({
        state: '{{ $statePath }}',
    })"
>
    <div class="flex flex-col justify-center items-center" x-ref="qr">
        @if(optional($options)['type'] === 'png')
            <img alt="" src="data:png;base64,{{ base64_encode(\LaraZeus\Qr\Facades\Qr::output($data,$options)) }}" />
        @else
            {{ \LaraZeus\Qr\Facades\Qr::output($data,$options) }}
        @endif
    </div>

    @if($downloadable)
        <div class="flex items-center gap-4">
            <x-filament::button
                :tooltip="__('Download as a PNG')"
                size="sm"
                icon="heroicon-o-arrow-down-tray"
                @click="download('{{ $fileName ?? $statePath }}','png');"
            >
                {{ __('png') }}
            </x-filament::button>
            <x-filament::button
                :tooltip="__('Download as an SVG')"
                size="sm"
                icon="heroicon-o-arrow-down-tray"
                @click="download('{{ $fileName ?? $statePath }}','svg');"
            >
                {{ __('svg') }}
            </x-filament::button>
        </div>
    @endif
</div>
