<?php

declare(strict_types=1);

namespace App\Helpers\Interfaces;

interface ArrayHelperInterface
{
    public function arrayDiff(array $compareFrom, array $compareAgainst): array;

    public function arrayIntersect(array $compareFrom, array $compareAgainst): array;
}
