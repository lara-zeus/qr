@php use Filament\Support\Facades\FilamentAsset; @endphp
<div>
    <div
        class="flex items-center justify-center"
        x-ignore
        ax-load-src="{{ FilamentAsset::getAlpineComponentSrc('qr','lara-zeus/qr') }}"
        ax-load
        x-data="qrPlugin({
            state: '{{ $parentName }}',
        })"
    >
    </div>

    <div class="{{ $parentName }} text-center flex flex-col justify-center items-center">

        {!! \LaraZeus\Qr\Facades\Qr::qrRender($$optionsName, $url) !!}

        <x-filament::button
            color="info"
            size="sm"
            icon="heroicon-o-arrow-down-tray"
            class="my-2"
            x-data=""
            @click="download('{{ $parentName }}');"
            {{--@click="$dispatch('async-alpine:load', { id: 'qrPlugin' })"--}}
        >
            Download
        </x-filament::button>

    </div>
</div>
