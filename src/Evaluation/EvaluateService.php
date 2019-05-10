<?php

declare(strict_types=1);

namespace App\Evaluation;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class EvaluateService implements Evaluate
{
    public function evaluateConditions(array $pluginResult, array $failureConditions): Result
    {
        $details = [];
        $expressionLanguage = new ExpressionLanguage();
        foreach ($failureConditions as $failureCondition) {
            $details[$failureCondition] = $expressionLanguage->evaluate($failureCondition, $pluginResult);
        }
        return new Result(!in_array(false, $details, true), $details);
    }
}
