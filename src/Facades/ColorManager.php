<?php

namespace LaraZeus\Qr\Facades;

use Spatie\Color\Rgb;
use Spatie\Color\Rgba;

class ColorManager
{
    public static function formatColor(string $getColor): array
    {
        return str($getColor)
            ->replace(['rgba(', ')', 'rgb(', ')'], '')
            ->explode(',')
            ->toArray();
    }

    public static function getColorAsArray(array $options, string $optionKey): array
    {
        $getColor = filled($options[$optionKey]) ? $options[$optionKey] : Qr::getDefaultOptions()[$optionKey];

        if (str($getColor)->startsWith('rgba')) {
            $getColorArray = static::formatColor(Rgba::fromString($getColor));
            $getColorArray[3] = $getColorArray[3] * 100;
        } else {
            $getColorArray = static::formatColor(Rgb::fromString($getColor));
        }

        return $getColorArray;
    }
}
