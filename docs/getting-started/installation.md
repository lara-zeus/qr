---
title: Installation
weight: 3
---

## Installation

Install @zeus Qr by running the following commands in your Laravel project directory.

```bash
composer require lara-zeus/qr
```

## Translations

Optionally, to publish the translation, run the command:

```bash
php artisan vendor:publish --tag=zeus-qr-translations
```

## Migration

Make sure to edit your resource migration to add the required columns.  
The main one will be the same as your component; in the example below, it is set as `qr_code`.  
If you want to store the personalization, another column is required; in the example, it is `options`.

```php
 Schema::create('ticket_replies', function (Blueprint $table) {
    // other columns   
    $table->string('qr_code');
    $table->text('options');
    // other columns
});
```

## Cast

The personalization's are stored as string but the component will use it as array so you need to tell to your model to cast it as array.

```php
class QrCode extends Model
{
    use HasFactory;

    protected $casts = [
        'options' => 'array'
    ];
}
```

## Usage:

use it in your resource

```php
\LaraZeus\Qr\Components\Qr::make('qr_code')
    // to open the designer as slide over instead of a modal.
    // Comment it out if you prefer the modal.
    ->asSlideOver()
    
    // you can set the column you want to save the QR design options, you must cast it to array in your model
    ->optionsColumn('options')
    
    // set the icon for the QR action
    ->actionIcon('heroicon-s-building-library')
    
    // more options soon
    ,
```

## Render the QR Code.

you can render the QR code in any component that accept HTML using the QR Facade:

```php
\LaraZeus\Qr\Facades\Qr::render(data:'dataOrUrl')
```

and it's accept these options:

```php
?string $data = null,
?array $options = null,
string $statePath = 'url',
string $optionsStatePath = 'options',
bool $downloadable = true
```

### Usage with Table and Infolist

to insert the QR code in any FilamentPHP table or infolist, it's better to be displayed in a popover or modal,

and you can use our plugin [Popover](https://larazeus.com/popover):

```php
PopoverEntry::make('name')
    ->trigger('click')
    ->placement('right')
    ->offset([0, 10])
    ->popOverMaxWidth('none')
    ->icon('heroicon-o-chevron-right')
    ->content(\LaraZeus\Qr\Facades\Qr::render(data:'dataOrUrl')),
```

If you just want to print the QrCode in the InfoList you can use TextEntry with `formatStateUsing` method and pass the state and the $record as params.

```php
TextEntry::make('qr_code')
    ->formatStateUsing(function (string $state, $record) {
        return \LaraZeus\Qr\Facades\Qr::render(
            data: $state,
            options: $record->options // This is your model. We are passing the personalizations. If you want the default just comment it out.
        );
    }),
```

### Usage with any action

to use the QR code as an action in anywhere you want:

```php
Action::make('qr-action')
    ->fillForm(fn(Model $record) => [
        'qr-options' => \LaraZeus\Qr\Facades\Qr::getDefaultOptions(),// or $record->qr-options
        'qr-data' => 'https://',// or $record->url
    ])
    ->form(\LaraZeus\Qr\Facades\Qr::getFormSchema('qr-data', 'qr-options'))
    ->action(fn($data) => dd($data)),
```

### upload configuration:

to customize the upload disk and directory pass the param:

```php
\LaraZeus\Qr\Facades\Qr::getFormSchema('qr-data', 'qr-options', uploadOptions: ['disk','/qr-code-logos'])
```