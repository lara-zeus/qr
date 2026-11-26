---
name: zeus-qr
description: Use when generating, customizing, storing, or rendering QR codes in Filament forms, actions, tables, or infolists with lara-zeus/qr.
---

# Lara Zeus Qr

## Overview & Requirements
`lara-zeus/qr` provides a Filament form field with a live QR code designer modal/slide-over (size, margin, colors, gradients, eye styles, error correction, logo overlay) plus a facade to render and download QR codes.
- **PHP**: `^8.1`
- **Filament**: `^5.0`
- **Dependencies**: `lara-zeus/simple-qrcode ^5.0`, `spatie/color ^1.0`
- **Package Name**: `lara-zeus/qr` (Service Provider: `LaraZeus\Qr\QrServiceProvider`)

## Installation
```bash
composer require lara-zeus/qr
```

Optionally publish translations:
```bash
php artisan vendor:publish --tag=zeus-qr-translations
```

## Configuration & Migrations
No package config or migrations are shipped; add two columns to your model's table (one for the URL/value, one for the JSON options) and cast the options column to `array`:
```php
// Migration
$table->string('qr_code');
$table->text('options')->nullable();

// Model
protected function casts(): array
{
    return [
        'options' => 'array',
    ];
}
```

## Filament Panel Registration
No panel plugin registration is required. Use the component, action, or facade directly.

## Core Usage & Examples

### Form Field (`LaraZeus\Qr\Components\Qr`)
```php
use LaraZeus\Qr\Components\Qr;

Qr::make('qr_code')
    ->optionsColumn('options') // default: 'options'
    ->asSlideOver() // open designer in a slide-over instead of modal
    ->actionIcon('heroicon-o-qr-code')
    ->uploadDisk('public')
    ->uploadDirectory('qr-logos')
    ->fileName('download');
```

### Rendering in Infolists, Tables, or Blade
```php
use Filament\Infolists\Components\TextEntry;
use LaraZeus\Qr\Facades\Qr;

// Direct render (returns HtmlString with optional download button)
Qr::render(
    data: $record->qr_code,
    options: $record->options,
    downloadable: true,
    fileName: 'my-qr',
);

// Inside a Filament Infolist TextEntry
TextEntry::make('qr_code')
    ->formatStateUsing(fn (string $state, $record) => Qr::render(
        data: $state,
        options: $record->options,
    ));
```

### Standalone Filament Action Schema
```php
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\Qr\Facades\Qr;

Action::make('qr-action')
    ->fillForm(fn (Model $record) => [
        'qr-options' => $record->options ?? Qr::getDefaultOptions(),
        'qr-data' => $record->qr_code ?? 'https://',
    ])
    ->schema(Qr::getFormSchema('qr-data', 'qr-options'))
    ->action(fn (array $data) => /* handle $data['qr-data'] and $data['qr-options'] */);
```

## Common Pitfalls / Anti-Patterns
- **Missing `'array'` cast on `optionsColumn`**: Saving/loading QR design options fails if the Eloquent attribute is not cast to `array`.
- **Uploading SVG logos**: `Qr::getFormSchema()` validates logos against `mimes:png,jpg,jpeg,gif,webp` and skips `.svg` files during merge.
- **Asset publishing**: Ensure Filament assets are up to date (`php artisan filament:assets`) so the `lara-zeus/qr` Alpine component is available.
