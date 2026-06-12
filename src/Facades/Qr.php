<?php

namespace LaraZeus\Qr\Facades;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;
use LaraZeus\QrCode\Generator;

class Qr extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'qr';
    }

    public static function getDefaultOptions(array $options = []): array
    {
        return array_merge([
            'size' => '300',
            'type' => 'png',
            'margin' => '1',
            'color' => 'rgba(74, 74, 74, 1)',
            'back_color' => 'rgba(252, 252, 252, 1)',
            'style' => 'square',
            'hasGradient' => false,
            'gradient_form' => 'rgb(69, 179, 157)',
            'gradient_to' => 'rgb(241, 148, 138)',
            'gradient_type' => 'vertical',
            'hasEyeColor' => false,
            'eye_color_inner' => 'rgb(241, 148, 138)',
            'eye_color_outer' => 'rgb(69, 179, 157)',
            'eye_style' => 'square',
            'correction' => 'H',
            'percentage' => '.2',
            'uploadOptions' => [
                'disk' => 'public',
                'directory' => null,
            ],
        ], $options);
    }

    public static function getFormSchema(
        string $statePath,
        string $optionsStatePath,
        ?string $defaultUrl = 'https://',
        bool $showUrl = true,
        array $uploadOptions = [],
        ?string $fileName = null
    ): array {
        return [
            TextInput::make($statePath)
                ->live(onBlur: true)
                ->formatStateUsing(fn ($state) => $state ?? $defaultUrl)
                ->visible($showUrl),

            Grid::make()
                ->columnSpanFull()
                ->schema([
                    Section::make()
                        ->id('main-card')
                        ->columns(['sm' => 2])
                        ->columnSpan(['sm' => 2, 'lg' => 1])
                        ->statePath($optionsStatePath)
                        ->schema([
                            Hidden::make('type')->default('png'),
                            Select::make('correction')
                                ->live()
                                ->default('H')
                                ->label(__('Correction'))
                                ->selectablePlaceholder(false)
                                ->columnSpan('full')
                                ->options([
                                    'L' => '7%',
                                    'M' => '15%',
                                    'Q' => '25%',
                                    'H' => '30%',
                                ]),

                            TextInput::make('size')
                                ->live()
                                ->default(300)
                                ->numeric()
                                ->label(__('Size')),

                            Select::make('margin')
                                ->live()
                                ->default(1)
                                ->label(__('Margin'))
                                ->selectablePlaceholder(false)
                                ->options([
                                    '0' => '0',
                                    '1' => '1',
                                    '3' => '3',
                                    '7' => '7',
                                    '9' => '9',
                                ]),

                            ColorPicker::make('color')
                                ->live()
                                ->default('rgba(74, 74, 74, 1)')
                                ->label(__('Color'))
                                ->rgba(),

                            ColorPicker::make('back_color')
                                ->live()
                                ->default('rgba(252, 252, 252, 1)')
                                ->label(__('Back Color'))
                                ->rgba(),

                            Select::make('style')
                                ->selectablePlaceholder(false)
                                ->live()
                                ->columnSpanFull()
                                ->label(__('Style'))
                                ->default('square')
                                ->options([
                                    'square' => __('square'),
                                    'round' => __('round'),
                                    'dot' => __('dot'),
                                ]),

                            Toggle::make('hasGradient')
                                ->live()
                                ->inline()
                                ->default(false)
                                ->columnSpanFull()
                                ->reactive()
                                ->label(__('Gradient')),

                            Grid::make()
                                ->schema([
                                    ColorPicker::make('gradient_form')
                                        ->live()
                                        ->default('rgb(69, 179, 157)')
                                        ->label(__('Gradient From'))
                                        ->rgb(),

                                    ColorPicker::make('gradient_to')
                                        ->live()
                                        ->default('rgb(241, 148, 138)')
                                        ->label(__('Gradient To'))
                                        ->rgb(),

                                    Select::make('gradient_type')
                                        ->selectablePlaceholder(false)
                                        ->columnSpanFull()
                                        ->default('vertical')
                                        ->live()
                                        ->label(__('Gradient Type'))
                                        ->options([
                                            'vertical' => __('vertical'),
                                            'horizontal' => __('horizontal'),
                                            'diagonal' => __('diagonal'),
                                            'inverse_diagonal' => __('inverse_diagonal'),
                                            'radial' => __('radial'),
                                        ]),
                                ])
                                ->columnSpan(['sm' => 2])
                                ->columns(['sm' => 2])
                                ->visible(fn (Get $get) => $get('hasGradient')),

                            Toggle::make('hasEyeColor')
                                ->live()
                                ->inline()
                                ->columnSpanFull()
                                ->default(false)
                                ->label(__('Eye Config')),

                            Grid::make()
                                ->schema([
                                    ColorPicker::make('eye_color_inner')
                                        ->live()
                                        ->default('rgb(241, 148, 138)')
                                        ->label(__('Inner Eye Color'))
                                        ->rgb(),

                                    ColorPicker::make('eye_color_outer')
                                        ->live()
                                        ->default('rgb(69, 179, 157)')
                                        ->label(__('Outer Eye Color'))
                                        ->rgb(),

                                    Select::make('eye_style')
                                        ->columnSpanFull()
                                        ->selectablePlaceholder(false)
                                        ->live()
                                        ->default('square')
                                        ->label(__('Eye Style'))
                                        ->options([
                                            'square' => __('square'),
                                            'circle' => __('circle'),
                                        ]),
                                ])
                                ->columnSpan(['sm' => 2])
                                ->columns(['sm' => 2])
                                ->visible(fn (Get $get) => $get('hasEyeColor')),

                            FileUpload::make('logo')
                                ->live()
                                ->imageEditor()
                                ->columnSpanFull()
                                ->disk($uploadOptions['disk'] ?? 'public')
                                ->directory($uploadOptions['directory'] ?? null)
                                ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/gif', 'image/webp'])
                                ->rules(['mimes:png,jpg,jpeg,gif,webp'])
                                ->validationMessages([
                                    'mimes' => __('svg not supported'),
                                    'mimetypes' => __('svg not supported'),
                                ]),

                            Select::make('percentage')
                                ->live()
                                ->default(.2)
                                ->label(__('Image Size'))
                                ->visible(fn (Get $get) => $get('logo'))
                                ->selectablePlaceholder(false)
                                ->columnSpan('full')
                                ->options([
                                    '.1' => 'S',
                                    '.2' => 'M',
                                    '.3' => 'L',
                                    '.4' => 'XL',
                                ]),
                        ]),

                    Placeholder::make('preview')
                        ->label(__('Preview'))
                        ->columns(['sm' => 2])
                        ->columnSpan(['sm' => 2, 'lg' => 1])
                        ->key('preview_placeholder')
                        ->content(fn (Get $get) => Qr::render(
                            data: $get($statePath),
                            options: $get($optionsStatePath),
                            statePath: $statePath,
                            optionsStatePath: $optionsStatePath,
                            fileName: $fileName
                        )),
                ]),
        ];
    }

    // @internal
    public static function output(?string $data = null, ?array $options = null): HtmlString
    {
        $maker = new Generator;
        $maker->encoding('UTF-8');
        $size = 0.2;

        $options = array_merge(Qr::getDefaultOptions(), $options ?? []);

        call_user_func_array(
            [$maker, 'color'],
            ColorManager::getColorAsArray($options, 'color')
        );

        call_user_func_array(
            [$maker, 'backgroundColor'],
            ColorManager::getColorAsArray($options, 'back_color')
        );

        $maker = $maker->size(filled($options['size']) ? $options['size'] : static::getDefaultOptions()['size']);

        if (isset($options['hasGradient']) && $options['hasGradient']) {
            if (filled($options['gradient_to'] ?? null) && filled($options['gradient_form'] ?? null)) {
                $gradient_form = ColorManager::getColorAsArray($options, 'gradient_form');
                $gradient_to = ColorManager::getColorAsArray($options, 'gradient_to');

                $gradientOptions = array_merge($gradient_to, $gradient_form, [$options['gradient_type'] ?? 'vertical']);
                call_user_func_array([$maker, 'gradient'], $gradientOptions);
            }
        }

        if (isset($options['hasEyeColor']) && $options['hasEyeColor']) {
            if (filled($options['eye_color_inner'] ?? null) && filled($options['eye_color_outer'] ?? null)) {
                $eye_color_inner = ColorManager::getColorAsArray($options, 'eye_color_inner');
                $eye_color_outer = ColorManager::getColorAsArray($options, 'eye_color_outer');

                $eyeColorInnerOptions0 = array_merge([0], $eye_color_inner, $eye_color_outer);
                call_user_func_array([$maker, 'eyeColor'], $eyeColorInnerOptions0);

                $eyeColorInnerOptions1 = array_merge([1], $eye_color_inner, $eye_color_outer);
                call_user_func_array([$maker, 'eyeColor'], $eyeColorInnerOptions1);

                $eyeColorInnerOptions2 = array_merge([2], $eye_color_inner, $eye_color_outer);
                call_user_func_array([$maker, 'eyeColor'], $eyeColorInnerOptions2);
            }
        }

        if (filled($options['margin'] ?? null)) {
            $maker = $maker->margin($options['margin']);
        }

        if (filled($options['correction'] ?? null)) {
            $maker = $maker->errorCorrection($options['correction']);
        }

        if (filled($options['percentage'] ?? null)) {
            $size = $options['percentage'];
        }

        if (filled($options['style'] ?? null)) {
            $maker = $maker->style($options['style']);
        }

        if (filled($options['eye_style'] ?? null)) {
            $maker = $maker->eye($options['eye_style']);
        }

        if (isset($options['logo']) && filled($options['logo'])) {
            reset($options['logo']);
            $logo = current($options['logo']);

            if ($logo instanceof UploadedFile && filled($logo->getPathName())) {
                if (! str($logo->getClientOriginalName())->endsWith('.svg') && $logo->getClientMimeType() !== 'image/svg+xml') {
                    $maker = $maker->merge($logo->getPathName(), $size, true);
                }
            } else {
                $disk = optional($options)['uploadOptions']['disk'] ?? 'public';
                if (Storage::disk($disk)->exists($logo) && ! str($logo)->endsWith('.svg') && Storage::disk($disk)->mimeType($logo) !== 'image/svg+xml') {
                    $maker = $maker->mergeString(
                        Storage::disk($disk)->get($logo),
                        $size
                    );
                }
            }
        }

        return new HtmlString(
            $maker->format(optional($options)['type'] ?? 'png')
                ->generate((filled($data) ? $data : 'https://'))
                ->toHtml()
        );
    }

    public static function render(
        ?string $data = null,
        ?array $options = null,
        string $statePath = 'url',
        string $optionsStatePath = 'options',
        bool $downloadable = true,
        ?string $fileName = null
    ): HtmlString {
        return new HtmlString(
            View::make('zeus-qr::download', [
                'optionsStatePath' => $optionsStatePath,
                'statePath' => $statePath,
                'fileName' => $fileName,
                'data' => $data,
                'options' => $options ?? Qr::getDefaultOptions(),
                'downloadable' => $downloadable,
            ])->render()
        );
    }
}
