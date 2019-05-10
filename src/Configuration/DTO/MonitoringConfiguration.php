<?php

declare(strict_types=1);

namespace App\Configuration\DTO;

use stdClass;

class MonitoringConfiguration
{
    private $connection;
    private $connector;
    private $options;

    public function __construct(stdClass $connection, stdClass $connector, Options $options)
    {
        $this->connection = $connection;
        $this->connector = $connector;
        $this->options = $options;
    }

    public function getConnection(): stdClass
    {
        return $this->connection;
    }

    public function getConnector(): stdClass
    {
        return $this->connector;
    }

    public function getOptions(): Options
    {
        return $this->options;
    }
}
