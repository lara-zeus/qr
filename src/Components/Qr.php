<?php

namespace LaraZeus\Qr\Components;

use Closure;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Generator;

class Qr extends TextInput
{
    protected string $view = 'zeus-matrix-choice::components.matrix-choice';

    protected array | Closure $columnData = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->hintAction(
            Action::make('qr-code-design')
                ->size('sm')
                ->fillForm(function (Get $get) {
                    $allOptions = \array_merge(
                        $this->getDefaultOptions(),
                        $get('link.options') ?? []
                    );

                    return [
                        'options' => $allOptions,
                        'url' => $get('link.url'),
                    ];
                })
                ->form(function (Get $get) {
                    $formOptions = [
                        'options' => $get('options.options'),
                        'url' => $get('options.url'),
                    ];

                    return $this->getFormSchema(array_merge($this->getDefaultOptions(), $formOptions));
                })
                // ->form($this->getFormSchema())
                ->action(function (Set $set, $data) {
                    $set('link', $data);
                })
                ->color('gray')
                ->icon('heroicon-o-qr-code')
                ->tooltip('customize the QR code design')
                ->iconButton()
        );
    }

    public function getFormSchema(array $data): array
    {
        return [
            Grid::make('2')
                ->schema([
                    TextInput::make('url')->default('https://'),
                    Section::make()
                        ->id('main-card')
                        ->columnSpan(1)
                        ->columns(['sm' => 1, 'md' => 2])
                        ->statePath('options')
                        ->schema([
                            TextInput::make('size')
                                ->live()
                                ->default(300)
                                ->label(__('Size')),

                            Select::make('margin')
                                ->live()
                                ->default(1)
                                ->label(__('Margin'))
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
                                ->live()
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
                                ->columnSpan([
                                    'sm' => 1,
                                    'lg' => 2,
                                ])
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
                                ->columns([
                                    'sm' => 1,
                                    'lg' => 3,
                                ])
                                ->columnSpan([
                                    'sm' => 1,
                                    'lg' => 2,
                                ])
                                ->visible(fn (\Filament\Forms\Get $get) => $get('hasGradient')),

                            Toggle::make('hasEyeColor')
                                ->live()
                                ->inline()
                                ->default(false)
                                ->columnSpan([
                                    'sm' => 1,
                                    'lg' => 2,
                                ])
                                ->label(__('Eye Config')),

                            Grid::make()->schema([
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
                                    ->live()
                                    ->default('square')
                                    ->label(__('Eye Style'))
                                    ->options([
                                        'square' => __('square'),
                                        'circle' => __('circle'),
                                    ]),
                            ])
                                ->columns([
                                    'sm' => 1,
                                    'lg' => 3,
                                ])
                                ->columnSpan([
                                    'sm' => 1,
                                    'lg' => 2,
                                ])
                                ->visible(fn (\Filament\Forms\Get $get) => $get('hasEyeColor')),
                        ]),

                    Placeholder::make('Preview')
                        ->columnSpan(1)
                        ->key('preview_placeholder')
                        ->hintAction(
                            Action::make('download')
                                ->icon('iconpark-downloadfour-o')
                                ->tooltip('Download')
                                ->action(function (Component $livewire) {
                                    $livewire->js("setTimeout(function(){
                                        download('qrcode');
                                    }, 100);");
                                })
                        )
                        ->content(function (Get $get, $state) {
                            return new HtmlString(
                                '<div id="qrcode" class="flex items-center justify-center">' .
                                $this->qrRender($get('options'), $get('url')) .
                                '</div>'
                            );
                        }),
                ]),
        ];
    }

    private function getDefaultOptions(): array
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

    public static function qrRender(array $data, ?string $url): string
    {
        $maker = new Generator();

        if ($data['color'] !== null) {
            $colorRGB = str_replace(['rgb(', ')'], '', $data['color']);
            $colorRGB = explode(',', $colorRGB);
            call_user_func_array([$maker, 'color'], $colorRGB);
        }

        if ($data['back_color'] !== null) {
            $back_colorRGB = str_replace(['rgb(', ')'], '', $data['back_color']);
            $back_colorRGB = explode(',', $back_colorRGB);
            call_user_func_array([$maker, 'backgroundColor'], $back_colorRGB);
        }

        $maker = $maker->size($data['size']);

        if ($data['hasGradient']) {
            if ($data['gradient_to'] !== null && $data['gradient_form'] !== null) {
                $gradient_form = str_replace(['rgb(', ')'], '', $data['gradient_form']);
                $gradient_form = explode(',', $gradient_form);

                $gradient_to = str_replace(['rgb(', ')'], '', $data['gradient_to']);
                $gradient_to = explode(',', $gradient_to);

                $options = array_merge($gradient_to, $gradient_form, [$data['gradient_type']]);
                call_user_func_array([$maker, 'gradient'], $options);
            }
        }

        if ($data['hasEyeColor']) {
            if ($data['eye_color_inner'] !== null && $data['eye_color_outer'] !== null) {
                $eye_color_inner = str_replace(['rgb(', ')'], '', $data['eye_color_inner']);
                $eye_color_inner = explode(',', $eye_color_inner);

                $eye_color_outer = str_replace(['rgb(', ')'], '', $data['eye_color_outer']);
                $eye_color_outer = explode(',', $eye_color_outer);

                $options = array_merge([0], $eye_color_inner, $eye_color_outer);
                call_user_func_array([$maker, 'eyeColor'], $options);

                $options = array_merge([1], $eye_color_inner, $eye_color_outer);
                call_user_func_array([$maker, 'eyeColor'], $options);

                $options = array_merge([2], $eye_color_inner, $eye_color_outer);
                call_user_func_array([$maker, 'eyeColor'], $options);
            }
        }

        if ($data['margin'] !== null) {
            $maker = $maker->margin($data['margin']);
        }

        if ($data['style'] !== null) {
            $maker = $maker->style($data['style']);
        }

        if (isset($data['eye_style']) && filled($data['eye_style'])) {
            $maker = $maker->eye($data['eye_style']);
        }

        /*if ($data['logo'] !== null) {
            $maker = $maker->merge('/public/images/logo-5-110px-instagram.png', .4,false);
        }*/

        // @phpstan-ignore-next-line
        return $maker->generate(($url ?? 'https://'))->toHtml();
    }

    public function columnData(array $data): static
    {
        $this->columnData = $data;

        return $this;
    }

    public function getColumnData(): array
    {
        return $this->evaluate($this->columnData);
    }
}
