<?php

declare(strict_types=1);

namespace App\Processor\DTO;

use DateTimeInterface;

class MonitoringData
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $payload;

    /**
     * @var int
     */
    private $priority;

    /**
     * @var int
     */
    private $idleTimeoutInSeconds;

    /**
     * @var DateTimeInterface
     */
    private $date;

    /** @var null|string */
    private $path;

    public function __construct(
        string $id,
        string $status,
        string $payload,
        int $priority,
        int $idleTimeoutInSeconds,
        DateTimeInterface $date,
        ?string $path
    ) {
        $this->id = $id;
        $this->status = $status;
        $this->payload = $payload;
        $this->priority = $priority;
        $this->idleTimeoutInSeconds = $idleTimeoutInSeconds;
        $this->date = $date;
        $this->path = $path;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getPayload(): string
    {
        return $this->payload;
    }

    public function getIdleTimeoutInSeconds(): int
    {
        return $this->idleTimeoutInSeconds;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }
}
