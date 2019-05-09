<?php

declare(strict_types=1);

namespace App\Configuration;

interface Merge
{
    public function mergeDefaults(array $configFromFile): array;
}
