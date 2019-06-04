<?php

declare(strict_types=1);

namespace App\Configuration\DTO;

class MonitoringConfiguration
{
    private $connection;
    private $connector;
    private $options;

    public function __construct(array $connection, array $connector, Options $options)
    {
        $this->connection = $connection;
        $this->connector = $connector;
        $this->options = $options;
    }

    public function getConnection(): array
    {
        return $this->connection;
    }

    public function getConnector(): array
    {
        return $this->connector;
    }

    public function getOptions(): Options
    {
        return $this->options;
    }
}
