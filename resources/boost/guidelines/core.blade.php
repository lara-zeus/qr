# Lara Zeus Qr (`lara-zeus/qr`)

FilamentPHP QR code input field, interactive designer modal/slide-over, and rendering facade powered by `lara-zeus/simple-qrcode`.

## Key Classes
- **Form Component**: `LaraZeus\Qr\Components\Qr` (extends `Filament\Forms\Components\Field`)
- **Facade**: `LaraZeus\Qr\Facades\Qr` (provides `getDefaultOptions()`, `getFormSchema()`, `render()`, `output()`)
- **Action**: `LaraZeus\Qr\Actions\QrOptionsAction` (extends `Filament\Actions\Action`)
- **Color Helper**: `LaraZeus\Qr\Facades\ColorManager`
- **Service Provider**: `LaraZeus\Qr\QrServiceProvider` (`$name = 'zeus-qr'`, registers `AlpineComponent::make('qr', ...)` under `'lara-zeus/qr'`)

## Rules & Anti-Patterns
- **No Filament Panel Plugin**: Do not register a panel plugin; use `LaraZeus\Qr\Components\Qr`, `QrOptionsAction`, or `LaraZeus\Qr\Facades\Qr` directly.
- **Two database columns & array cast**: The `Qr` field stores the URL/data in the field's column (e.g. `qr_code`) and design configuration in a separate column (`options` by default, configurable via `->optionsColumn('...')`). Cast the options column to `'array'` on the Eloquent model.
- **No SVG logos**: Logo uploads only support `png, jpg, jpeg, gif, webp`; SVG files are explicitly rejected.
- **Downloadable rendering**: `Qr::render(...)` returns an `HtmlString` with the QR image and download UI (`zeus-qr::download`), whereas `Qr::output(...)` returns only the raw QR `HtmlString`.
