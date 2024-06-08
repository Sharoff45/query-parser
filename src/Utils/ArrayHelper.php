<?php

declare(strict_types=1);

namespace FpDbTest\Utils;

readonly class ArrayHelper
{
    public function isAssociativeArray(array $array): bool
    {
        if ($array === []) {
            return false;
        }

        return array_keys($array) !== range(0, count($array) - 1);
    }
}