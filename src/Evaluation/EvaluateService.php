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
        return new Result($this->allFailureConditionsMet($details), $details);
    }

    private function allFailureConditionsMet(array $details): bool
    {
        /*
         * all failure conditions must be true in order to trigger a monitoring,
         * therefore if any failure conditions is false, the monitoring should not trigger
         */
        return !in_array(false, $details, true);
    }
}
