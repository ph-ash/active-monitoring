<?php

declare(strict_types=1);

namespace App\Connector\MySQL;

use App\Configuration\DTO\MonitoringConfiguration;
use App\Connector\Monitoring as MonitoringInterface;
use Doctrine\DBAL\DriverManager;

class Monitoring implements MonitoringInterface
{
    public function execute(MonitoringConfiguration $configuration): array
    {
        if (empty($configuration->getConnection()['url'])) {
            $options = [
                'driver' => 'pdo_mysql',
                'host' => $configuration->getConnection()['host'],
                'port' => $configuration->getConnection()['port'],
                'user' => $configuration->getConnection()['user'],
                'password' => $configuration->getConnection()['password'],
            ];
        } else {
            $options = [
                'url' => $configuration->getConnection()['url'],
            ];
        }

        $connection = DriverManager::getConnection($options);

        return $connection->fetchAssoc($configuration->getConnector()['sql']);
    }
}
