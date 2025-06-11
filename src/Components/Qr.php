<?php

namespace LaraZeus\Qr\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use LaraZeus\Qr\Actions\QrOptionsAction;

class Qr extends Field
{
    public string $uploadDisk = 'public';

    public ?string $uploadDirectory = null;

    public string $optionsColumn = 'options';

    public bool $asSlideOver = false;

    public string $actionIcon = 'heroicon-o-qr-code';

    protected string $view = 'filament-schemas::components.grid';

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->schema(function () {
                $getName = $this->getName();
                $getOptionsColumn = $this->getOptionsColumn();

                return [
                    Hidden::make($getOptionsColumn),

                    TextInput::make($getName)
                        ->live()
                        ->default('https://')
                        ->suffixAction(
                            QrOptionsAction::make('qr-code-design')
                                ->slideOver(fn() => $this->isAsSlideOver())
                                ->icon(fn() => $this->getActionIcon())
                                ->parentState($getName)
                                ->optionsColumn($getOptionsColumn)
                                ->uploadOptions($this->getUploadDisk(), $this->getUploadDisk())
                        ),
                ];
            });
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

    public function asSlideOver(bool $condition = true): static
    {
        $this->asSlideOver = $condition;

        return $this;
    }

    public function isAsSlideOver(): bool
    {
        return $this->asSlideOver;
    }

    public function actionIcon(string $icon): static
    {
        $this->actionIcon = $icon;

        return $this;
    }

    public function getActionIcon(): string
    {
        return $this->actionIcon;
    }

    public function uploadDisk(string $disk = 'public'): static
    {
        $this->uploadDisk = $disk;

        return $this;
    }

    public function getUploadDisk(): string
    {
        return $this->uploadDisk;
    }

    public function uploadDirectory(?string $dir = null): static
    {
        $this->uploadDirectory = $dir;

        return $this;
    }

    public function getUploadDirectory(): string
    {
        return $this->uploadDirectory;
    }
}
