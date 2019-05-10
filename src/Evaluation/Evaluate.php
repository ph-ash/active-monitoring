<?php

declare(strict_types=1);

namespace App\Evaluation;

interface Evaluate
{
    public function evaluateConditions(array $pluginResult, array $failureConditions): Result;
}
