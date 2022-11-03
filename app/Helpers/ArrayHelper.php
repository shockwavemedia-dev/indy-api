<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Helpers\Interfaces\ArrayHelperInterface;

final class ArrayHelper implements ArrayHelperInterface
{
    public function arrayDiff(array $compareFrom, array $compareAgainst): array
    {
        $diff = [];

        // we don't care about keys anyway + avoids dupes
        foreach ($compareFrom as $value) {
            $diff[$value] = 1;
        }

        // unset common values
        foreach ($compareAgainst as $value) {
            unset($diff[$value]);
        }

        return array_keys($diff);
    }

    public function arrayIntersect(array $compareFrom, array $compareAgainst): array
    {
        $firstArray = $secondArray = array();

        // we don't care about keys anyway + avoids dupes
        foreach ($compareFrom as $value) {
            $firstArray[$value] = $value;
        }
        foreach ($compareAgainst as $value) {
            $secondArray[$value] = 1;
        }

        // unset different values values
        foreach ($firstArray as $value) {
            if (!isset($secondArray[$value])) {
                unset($firstArray[$value]);
            }
        }

        return array_keys($firstArray);
    }
}
