<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class KrshortArray extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('krshort', [$this, 'krshort']),
        ];
    }

    public function krshort(array $array): array
    {
        krsort($array);
        return $array;
    }
}
