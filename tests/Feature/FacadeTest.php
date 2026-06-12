<?php

use Illuminate\Support\HtmlString;
use LaraZeus\Qr\Facades\Qr;

it('returns default options', function () {
    $options = Qr::getDefaultOptions();

    expect($options)->toBeArray()
        ->and($options)->toHaveKeys([
            'size', 'type', 'margin', 'color', 'back_color',
            'style', 'hasGradient', 'gradient_form', 'gradient_to',
            'gradient_type', 'hasEyeColor', 'eye_color_inner',
            'eye_color_outer', 'eye_style', 'correction',
            'percentage', 'uploadOptions',
        ])
        ->and($options['size'])->toBe('300')
        ->and($options['type'])->toBe('png')
        ->and($options['margin'])->toBe('1')
        ->and($options['color'])->toBe('rgba(74, 74, 74, 1)')
        ->and($options['back_color'])->toBe('rgba(252, 252, 252, 1)');
});

it('can merge custom options with default options', function () {
    $options = Qr::getDefaultOptions(['size' => '500', 'type' => 'svg']);

    expect($options['size'])->toBe('500')
        ->and($options['type'])->toBe('svg')
        ->and($options['margin'])->toBe('1');
});

it('returns a form schema array', function () {
    $schema = Qr::getFormSchema('url', 'options');

    expect($schema)->toBeArray()
        ->and($schema)->toHaveCount(2);
});

it('can render output qr code as svg', function () {
    $output = Qr::output('https://larazeus.com', ['type' => 'svg']);

    expect($output)->toBeInstanceOf(HtmlString::class)
        ->and($output->toHtml())->toContain('<svg');
});
