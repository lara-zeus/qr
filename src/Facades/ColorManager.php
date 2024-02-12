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
            try {
                $rgbaColor = Rgba::fromString($getColor);
            } catch (\Exception) {
                $rgbaColor = Rgba::fromString(Qr::getDefaultOptions()[$optionKey]);
            }
            $getColorArray = static::formatColor($rgbaColor);
            $getColorArray[3] = $getColorArray[3] * 100;
        } else {
            try {
                $rgbColor = Rgb::fromString($getColor);
            } catch (\Exception) {
                $rgbColor = Rgb::fromString(Qr::getDefaultOptions()[$optionKey]);
            }
            $getColorArray = static::formatColor($rgbColor);
        }

        return $getColorArray;
    }
}
