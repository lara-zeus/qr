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
    // to open the designer as slideover instead of a modal
    ->asSlideOver()
    
    //you can set the column you want to save the QR design options, you must cast it to array in your model
    ->optionsColumn('string')
    
    // set the icon for the QR action
    ->actionIcon('heroicon-s-building-library')
    
    // more options soon
    ,
```

and soon for table and infolist.
