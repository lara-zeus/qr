<?php

namespace LaraZeus\Qr\Actions;

use Closure;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Get;
use Filament\Forms\Set;
use LaraZeus\Qr\Facades\Qr;

class QrOptionsAction extends Action
{
    public string $parentState = 'url';

    public string $optionsColumn = 'options';

    public ?Closure $configureActionUsing;

    public static function make(?string $name = null): static
    {
        $make = parent::make($name);

        // todo, getting $configureActionUsing must not be accessed before initialization
        /*$make->configureUsing(function ($make){
            return $make->getActionConfig();
        });*/

        return $make;
    }

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

        $this->form(fn () => Qr::getFormSchema($this->getParentState(), $this->getOptionsColumn()));

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

    public function getParentState(): string
    {
        return $this->evaluate($this->parentState ?? 'url');
    }

    public function configureActionUsing(Closure $callback): static
    {
        $this->configureActionUsing = $callback;

        return $this;
    }

    public function getActionConfig(): ?Closure
    {
        return $this->configureActionUsing;
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
}
