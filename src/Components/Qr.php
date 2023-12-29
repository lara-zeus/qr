<?php

namespace LaraZeus\Qr\Components;

use Closure;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Concerns\HasName;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use LaraZeus\Qr\Actions\QrOptionsAction;

class Qr extends Component
{
    use HasName;

    public ?Closure $configureActionUsing = null;

    public string $optionsColumn;

    public bool $asSlideOver = false;

    public string $actionIcon = 'heroicon-o-qr-code';

    protected string $view = 'filament-forms::components.grid';

    public function __construct(string $name)
    {
        $this->name($name);
    }

    public static function make(string $name): static
    {
        $static = app(static::class, ['name' => $name]);

        $static->configure();

        return $static;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->schema(function () {

            $getName = $this->getName();
            $getOptionsColumn = $this->getOptionsColumn();

            return [
                Hidden::make($getOptionsColumn),

                TextInput::make($getName)
                    ->live()
                    ->default('https://')
                    ->suffixAction(
                        QrOptionsAction::make('qr-code-design')
                            ->slideOver(fn () => $this->isAsSlideOver())
                            ->icon(fn () => $this->getActionIcon())
                            ->parentState($getName)
                            ->optionsColumn($getOptionsColumn)
                        /*->configureActionUsing(function (QrOptionsAction $action) {
                            return $this->getConfigureActionUsing($action);
                        })*/
                    ),
            ];
        });
    }

    public function configureActionUsing(?Closure $callback): static
    {
        $this->configureActionUsing = $callback;

        return $this;
    }

    public function getConfigureActionUsing(Action $action): ?Closure
    {
        return $this->evaluate($this->configureActionUsing, [
            'action' => $action,
        ]);
    }

    public function optionsColumn(string $column): static
    {
        $this->optionsColumn = $column;

        return $this;
    }

    public function getOptionsColumn(): string
    {
        return $this->optionsColumn;
    }

    public function asSlideOver(bool $condetion = true): static
    {
        $this->asSlideOver = $condetion;

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
}
