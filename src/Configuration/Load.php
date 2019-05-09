<?php

declare(strict_types=1);

namespace App\Configuration;

interface Load
{
    public function load(): array;
}
