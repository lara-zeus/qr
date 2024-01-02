<?php

namespace LaraZeus\Qr\Facades;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\HtmlString;
use SimpleSoftwareIO\QrCode\Generator;

class Qr extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'helen';
    }

    public static function getDefaultOptions(): array
    {
        return [
            'size' => '300',
            'margin' => '1',
            'color' => 'rgb(74, 74, 74)',
            'back_color' => 'rgb(252, 252, 252)',
            'style' => 'square',
            'hasGradient' => false,
            'gradient_form' => 'rgb(69, 179, 157)',
            'gradient_to' => 'rgb(241, 148, 138)',
            'gradient_type' => 'vertical',
            'hasEyeColor' => false,
            'eye_color_inner' => 'rgb(241, 148, 138)',
            'eye_color_outer' => 'rgb(69, 179, 157)',
            'eye_style' => 'square',
        ];
    }

    public static function getFormSchema(string $statePath, string $optionsStatePath, bool $showUrl = true): array
    {
        return [
            TextInput::make($statePath)
                //->visible($showUrl) // todo for helen
                ->default('https://'),

            Grid::make()
                ->schema([

                    Section::make()
                        ->id('main-card')
                        ->columns(['sm' => 2])
                        ->columnSpan(['sm' => 2, 'lg' => 1])
                        ->statePath($optionsStatePath)
                        ->schema([
                            TextInput::make('size')
                                ->live()
                                ->default(300)
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
                                ->default('rgb(74, 74, 74)')
                                ->label(__('Color'))
                                ->rgb(),

                            ColorPicker::make('back_color')
                                ->live()
                                ->default('rgb(252, 252, 252)')
                                ->label(__('Back Color'))
                                ->rgb(),

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
                                        ->default('rgb(241, 148, 138)')
                                        ->live()
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
                        ]),

                    Placeholder::make('preview')
                        ->columns(['sm' => 2])
                        ->columnSpan(['sm' => 2, 'lg' => 1])
                        ->key('preview_placeholder')
                        ->content(fn (Get $get) => Qr::render(
                            data: $get($statePath),
                            options: $get($optionsStatePath),
                            statePath: $statePath,
                            optionsStatePath: $optionsStatePath
                        )),
                ]),
        ];
    }

    // @internal
    public static function output(?string $data = null, ?array $options = null): HtmlString
    {
        $maker = new Generator();

        $options = $options ?? Qr::getDefaultOptions();

        $getColor = filled($options['color']) ? $options['color'] : static::getDefaultOptions()['color'];
        $getColorArray = str($getColor)->replace(['rgb(', ')'], '')->explode(',')->toArray();
        call_user_func_array([$maker, 'color'], $getColorArray);

        $getBackColor = filled($options['back_color']) ? $options['back_color'] : static::getDefaultOptions()['back_color'];
        $colorBackRGB = str($getBackColor)->replace(['rgb(', ')'], '')->explode(',')->toArray();
        call_user_func_array([$maker, 'backgroundColor'], $colorBackRGB);

        $maker = $maker->size($options['size'] ?? static::getDefaultOptions()['size']);

        if ($options['hasGradient']) {
            if (filled($options['gradient_to']) && filled($options['gradient_form'])) {
                $gradient_form = str($options['gradient_form'])->replace(['rgb(', ')'], '')->explode(',')->toArray();
                $gradient_to = str($options['gradient_to'])->replace(['rgb(', ')'], '')->explode(',')->toArray();

                $gradientOptions = array_merge($gradient_to, $gradient_form, [$options['gradient_type']]);
                call_user_func_array([$maker, 'gradient'], $gradientOptions);
            }
        }

        if ($options['hasEyeColor']) {
            if (filled($options['eye_color_inner']) && filled($options['eye_color_outer'])) {
                $eye_color_inner = str($options['eye_color_inner'])->replace(
                    ['rgb(', ')'],
                    ''
                )->explode(',')->toArray();
                $eye_color_outer = str($options['eye_color_outer'])->replace(
                    ['rgb(', ')'],
                    ''
                )->explode(',')->toArray();

                $eyeColorInnerOptions = array_merge([0], $eye_color_inner, $eye_color_outer);
                call_user_func_array([$maker, 'eyeColor'], $eyeColorInnerOptions);

                $eyeColorInnerOptions = array_merge([1], $eye_color_inner, $eye_color_outer);
                call_user_func_array([$maker, 'eyeColor'], $eyeColorInnerOptions);

                $eyeColorInnerOptions = array_merge([2], $eye_color_inner, $eye_color_outer);
                call_user_func_array([$maker, 'eyeColor'], $eyeColorInnerOptions);
            }
        }

        if (filled($options['margin'])) {
            $maker = $maker->margin($options['margin']);
        }

        if (filled($options['style'])) {
            $maker = $maker->style($options['style']);
        }

        if (filled($options['eye_style'])) {
            $maker = $maker->eye($options['eye_style']);
        }

        /*if ($options['logo'] !== null) {
            $maker = $maker->merge('/public/images/logo-5-110px-instagram.png', .4,false);
        }*/

        return new HtmlString(
            // @phpstan-ignore-next-line
            $maker->generate(($data ?? 'https://'))->toHtml()
        );
    }

    public static function render(
        ?string $data = null,
        ?array $options = null,
        string $statePath = 'url',
        string $optionsStatePath = 'options',
        bool $downloadable = true
    ): HtmlString {
        return new HtmlString(
            view('zeus-qr::download', [
                'optionsStatePath' => $optionsStatePath,
                'statePath' => $statePath,
                'data' => $data,
                'options' => $options ?? Qr::getDefaultOptions(),
                'downloadable' => $downloadable,
            ])->render()
        );
    }
}
