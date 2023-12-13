<?php

namespace LaraZeus\Qr\Components;

use Closure;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Concerns\HasName;
use Filament\Forms\Components\TextInput;
use LaraZeus\Qr\Actions\QrOptionsAction;

class Qr extends Component
{
    use HasName;

    public Closure|null $configureActionUsing = null;

    protected string $view = 'filament-forms::components.grid';

    public function __construct(string $name)
    {
        $this->name($name);

        $this->statePath($name);
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
            return [
                TextInput::make($getName.'.url')
                    ->live()
                    ->default('https://')
                    ->hintAction(
                        QrOptionsAction::make('qr-code-design')
                            ->parentState($getName)
                            ->configureActionUsing(function (QrOptionsAction $action) {
                                return $this->getConfigureActionUsing($action);
                            })
                    ),
            ];
        });
    }

    public function configureActionUsing(Closure|null $callback): static
    {
        $this->configureActionUsing = $callback;

        return $this;
    }

    public function getConfigureActionUsing(Action $action): Closure|null
    {
        return $this->evaluate($this->configureActionUsing, [
            'action' => $action,
        ]);
    }
}