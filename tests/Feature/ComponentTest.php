<?php

use LaraZeus\Qr\Components\Qr;

it('can initialize qr component', function () {
    $field = Qr::make('test_qr');

    expect($field)->toBeInstanceOf(Qr::class)
        ->and($field->getName())->toBe('test_qr')
        ->and($field->getOptionsColumn())->toBe('options')
        ->and($field->getActionIcon())->toBe('heroicon-o-qr-code')
        ->and($field->getUploadDisk())->toBe('public')
        ->and($field->getUploadDirectory())->toBeNull()
        ->and($field->getFileName())->toBe('download');
});

it('can configure options column', function () {
    $field = Qr::make('test_qr')->optionsColumn('custom_options');

    expect($field->getOptionsColumn())->toBe('custom_options');
});

it('can configure slide over', function () {
    $field = Qr::make('test_qr')->asSlideOver();

    expect($field->isAsSlideOver())->toBeTrue();
});

it('can configure action icon', function () {
    $field = Qr::make('test_qr')->actionIcon('heroicon-o-check');

    expect($field->getActionIcon())->toBe('heroicon-o-check');
});

it('can configure upload disk', function () {
    $field = Qr::make('test_qr')->uploadDisk('s3');

    expect($field->getUploadDisk())->toBe('s3');
});

it('can configure upload directory', function () {
    $field = Qr::make('test_qr')->uploadDirectory('qr-codes');

    expect($field->getUploadDirectory())->toBe('qr-codes');
});

it('can configure file name', function () {
    $field = Qr::make('test_qr')->fileName('custom_download');

    expect($field->getFileName())->toBe('custom_download');
});
