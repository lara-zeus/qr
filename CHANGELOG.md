# Changelog

All notable changes to `Qr` will be documented in this file

## 1.2.3 - 2025-06-14

### What's Changed

* customize file name for downloaded QR by @atmonshi in https://github.com/lara-zeus/qr/pull/51

**Full Changelog**: https://github.com/lara-zeus/qr/compare/2.0.0...1.2.3

## 1.2.2 - 2025-04-04

### What's Changed

* allow to configure the upload disk and directory by @atmonshi in https://github.com/lara-zeus/qr/pull/48

```php
\LaraZeus\Qr\Components\Qr::make('qr_code')
    // to customize the upload disk
    ->uploadDisk('public')
   
    // to customize the upload directory
    ->uploadDirectory('qr-dir'),


```
**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.2.1...1.2.2

## 1.2.1 - 2025-03-05

### What's Changed

* fix namespace by @atmonshi in https://github.com/lara-zeus/qr/pull/45

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.2.0...1.2.1

## 1.2.0 - 2025-03-05

### What's Changed

* bump simple-qrcode by @atmonshi in https://github.com/lara-zeus/qr/pull/44

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.1.19...1.2.0

## 1.1.19 - 2025-03-02

### What's Changed

* update ax-load by @atmonshi in https://github.com/lara-zeus/qr/pull/43

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.1.18...1.1.19

## 1.1.18 - 2025-02-21

### What's Changed

* Bump dependabot/fetch-metadata from 2.2.0 to 2.3.0 by @dependabot in https://github.com/lara-zeus/qr/pull/40
* Bump aglipanci/laravel-pint-action from 2.4 to 2.5 by @dependabot in https://github.com/lara-zeus/qr/pull/41
* Allow passing option overrides in getDefaultOptions by @sprtk-ches in https://github.com/lara-zeus/qr/pull/42

### New Contributors

* @sprtk-ches made their first contribution in https://github.com/lara-zeus/qr/pull/42

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.1.17...1.1.18

## 1.1.17 - 2024-12-22

### What's Changed

* custom form by @do-dyco in https://github.com/lara-zeus/qr/pull/37

### New Contributors

* @do-dyco made their first contribution in https://github.com/lara-zeus/qr/pull/37

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.1.16...1.1.17

## 1.1.16 - 2024-09-02

### What's Changed

* Bump dependabot/fetch-metadata from 2.1.0 to 2.2.0 by @dependabot in https://github.com/lara-zeus/qr/pull/32
* Add logo to QR code by @atmonshi in https://github.com/lara-zeus/qr/pull/34

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.1.15...1.1.16

## 1.1.15 - 2024-06-28

### What's Changed

* Docs: Update installation and database migrations by @cgiupponi in https://github.com/lara-zeus/qr/pull/30

### New Contributors

* @cgiupponi made their first contribution in https://github.com/lara-zeus/qr/pull/30

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.1.14...1.1.15

## 1.1.14 - 2024-06-26

### What's Changed

* fix set state in modal by @atmonshi in https://github.com/lara-zeus/qr/pull/28

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.1.13...1.1.14

## 1.1.13 - 2024-06-13

### What's Changed

* support png type to render qr in tables by @atmonshi in https://github.com/lara-zeus/qr/pull/27

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.1.12...1.1.13

## 1.1.12 - 2024-06-10

### What's Changed

* Bump aglipanci/laravel-pint-action from 2.3.1 to 2.4 by @dependabot in https://github.com/lara-zeus/qr/pull/24
* Update ColorManager.php by @schrempfra in https://github.com/lara-zeus/qr/pull/26
* Bump dependabot/fetch-metadata from 1.6.0 to 2.1.0 by @dependabot in https://github.com/lara-zeus/qr/pull/25

### New Contributors

* @schrempfra made their first contribution in https://github.com/lara-zeus/qr/pull/26

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.1.11...1.1.12

## 1.1.11 - 2024-03-05

### What's Changed

* Bump ramsey/composer-install from 2 to 3 by @dependabot in https://github.com/lara-zeus/qr/pull/21
* Improving Download Action by @dbpolito in https://github.com/lara-zeus/qr/pull/22

### New Contributors

* @dbpolito made their first contribution in https://github.com/lara-zeus/qr/pull/22

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.1.10...1.1.11

## 1.1.10 - 2024-02-24

### What's Changed

* Change the type of the input text `size` to numeric and check if the size is empty, return the default size by @waelkhalifa in https://github.com/lara-zeus/qr/pull/19
* making data input live onBlur by @atmonshi in https://github.com/lara-zeus/qr/pull/20

### New Contributors

* @waelkhalifa made their first contribution in https://github.com/lara-zeus/qr/pull/19

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.1.9...1.1.10

## 1.1.9 - 2024-02-12

### What's Changed

* fix set colors by @atmonshi in https://github.com/lara-zeus/qr/pull/17

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.1.8...1.1.9

## 1.1.8 - 2024-02-09

### What's Changed

* fix defualt gradient value by @atmonshi in https://github.com/lara-zeus/qr/pull/16

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.1.7...1.1.8

## 1.1.7 - 2024-02-05

### What's Changed

* fix reactive color picker by @atmonshi in https://github.com/lara-zeus/qr/pull/15

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.1.6...1.1.7

## 1.1.6 - 2024-01-28

### What's Changed

* add translate by @T1anjiu in https://github.com/lara-zeus/qr/pull/14

### New Contributors

* @T1anjiu made their first contribution in https://github.com/lara-zeus/qr/pull/14

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.1.5...1.1.6

## 1.1.5 - 2024-01-24

### What's Changed

* add translation by @atmonshi in https://github.com/lara-zeus/qr/pull/13

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.1.4...1.1.5

## 1.1.4 - 2024-01-14

### What's Changed

* set default values if the user didn't set one by @atmonshi in https://github.com/lara-zeus/qr/pull/11

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.1.3...1.1.4

## 1.1.3 - 2024-01-12

### What's Changed

* build assets by @atmonshi in https://github.com/lara-zeus/qr/pull/9

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.1.2...1.1.3

## 1.1.2 - 2024-01-12

### What's Changed

* download QR code as SVG by @atmonshi in https://github.com/lara-zeus/qr/pull/8

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.1.1...1.1.2

## 1.1.1 - 2024-01-12

### What's Changed

#### new feature:

* add the ability to select transparent background color by @atmonshi in https://github.com/lara-zeus/qr/pull/7

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.1.0...1.1.1

## 1.1.0 - 2024-01-02

### What's Changed

* Bump aglipanci/laravel-pint-action from 2.3.0 to 2.3.1 by @dependabot in https://github.com/lara-zeus/qr/pull/4
* ✨ make it easier to render QR anywhere in your app by @atmonshi in https://github.com/lara-zeus/qr/pull/5

### New Contributors

* @dependabot made their first contribution in https://github.com/lara-zeus/qr/pull/4

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.0.4...1.1.0

## 1.0.4 - 2023-12-29

### What's Changed

* fix using custom options column by @atmonshi in https://github.com/lara-zeus/qr/pull/3
* improve responsive UI

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.0.3...1.0.4

## 1.0.3 - 2023-12-15

### What's Changed

* allow to customize QR action by @atmonshi in https://github.com/lara-zeus/qr/pull/2

**Full Changelog**: https://github.com/lara-zeus/qr/compare/1.0.2...1.0.3

## v1.0.0 - 2023-12-12

- initial release
