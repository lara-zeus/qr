<?php

namespace LaraZeus\Qr\Actions;

use Filament\Actions\Action;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use LaraZeus\Qr\Facades\Qr;

class QrOptionsAction extends Action
{
    public array $uploadOptions = [];

    public string $parentState = 'url';

    public string $optionsColumn = 'options';

    public ?string $fileName = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fillForm(function (Get $get) {
            $getName = $this->getParentState();
            $getOptionsColumn = $this->getOptionsColumn();
            $data = $get($getOptionsColumn) ?? Qr::getDefaultOptions();

            return [
                $getOptionsColumn => $data,
                $getName => $get($getName),
            ];
        });

        $this->schema(fn () => Qr::getFormSchema(
            statePath: $this->getParentState(),
            optionsStatePath: $this->getOptionsColumn(),
            uploadOptions: $this->getUploadOptions(),
            fileName: $this->getFileName()
        ));

        $this->action(function (Set $set, $data) {
            $set($this->getParentState(), $data[$this->getParentState()]);
            $set($this->getOptionsColumn(), $data[$this->getOptionsColumn()]);
        });

        $this
            ->color('gray')
            ->tooltip(__('customize the QR code design'))
            ->iconButton();

        $this->modalHeading(fn (): string => __('QR code Design'));

        $this->modalDescription(fn (): string => __('customize the QR code design'));

        $this->modalIcon('heroicon-o-qr-code');

        $this->modalIconColor('info');

        $this->modalSubmitActionLabel(__('save'));

        $this->modalCancelAction(false);

        $this->successNotificationTitle(__('Saved Successfully'));
    }

    public function parentState(string $url = 'url'): static
    {
        $this->parentState = $url;

        return $this;
    }

    public function uploadOptions(string $disk = 'public', ?string $directory = null): static
    {
        $this->uploadOptions = [
            'disk' => $disk,
            'directory' => $directory,
        ];

        return $this;
    }

    public function getUploadOptions(): array
    {
        return $this->uploadOptions;
    }

    public function getParentState(): string
    {
        return $this->evaluate($this->parentState ?? 'url');
    }

    public function optionsColumn(string $column = 'options'): static
    {
        $this->optionsColumn = $column;

        return $this;
    }

    public function getOptionsColumn(): string
    {
        return $this->optionsColumn ?? 'options';
    }

    public function fileName(?string $name = null): static
    {
        $this->fileName = $name;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }
}
