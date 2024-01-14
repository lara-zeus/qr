---
title: Installation
weight: 3
---

## Installation

Install @zeus Qr by running the following commands in your Laravel project directory.

```bash
composer require lara-zeus/qr
```

## Usage:

use it in your resource

```php
\LaraZeus\Qr\Components\Qr::make('qr_code')
    // to open the designer as slide over instead of a modal
    ->asSlideOver()
    
    //you can set the column you want to save the QR design options, you must cast it to array in your model
    ->optionsColumn('string')
    
    // set the icon for the QR action
    ->actionIcon('heroicon-s-building-library')
    
    // more options soon
    ,
```

## Render the QR Code.

you can render the QR code in any component that accept HTML using the QR Facade:

```php
Qr::render(data:'dataOrUrl')
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
    ->content(Qr::render(data:'dataOrUrl')),
```

### Usage with any action

to use the QR code as an action in anywhere you want:

```php
Action::make('qr-action')
    ->fillForm(fn(Model $record) => [
        'qr-options' => Qr::getDefaultOptions(),// or $record->qr-options
        'qr-data' => 'https://',// or $record->url
    ])
    ->form(Qr::getFormSchema('qr-data', 'qr-options'))
    ->action(fn($data) => dd($data)),
```
