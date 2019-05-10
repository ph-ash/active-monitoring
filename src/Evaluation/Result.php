<?php

declare(strict_types=1);

namespace App\Evaluation;

class Result
{
    private $value;
    private $details;

    public function __construct(bool $value, array $details)
    {
        $this->value = $value;
        $this->details = $details;
    }

    public function isValue(): bool
    {
        return $this->value;
    }

    public function getDetails(): array
    {
        return $this->details;
    }
}
