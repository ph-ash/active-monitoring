<?php

declare(strict_types=1);

namespace App\Configuration;

use Symfony\Component\PropertyAccess\PropertyAccess;
use function array_merge;

class MergeService implements Merge
{
    public function mergeDefaults(array $configFromFile): array
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $mergedConfig = [];

        foreach ($configFromFile['phash']['active_monitoring'] as $key => $config) {
            $defaults = $propertyAccessor->getValue($config, '[defaults]');
            if (empty($defaults)) {
                $mergedConfig[$key]['monitorings'] = $config['monitorings'];
                continue;
            }

            $defaultsConnection = $propertyAccessor->getValue($defaults, '[connection]');
            $defaultsMonitorings = $propertyAccessor->getValue($defaults, '[monitorings]');

            $monitorings = [];
            foreach ($config['monitorings'] as $monitoringKey => $monitoring) {
                $connection = $propertyAccessor->getValue($monitoring, '[connection]') ?? [];
                if (!empty($defaultsConnection)) {
                    $monitoring['connection'] = array_merge($defaultsConnection, $connection);
                }
                if (!empty($defaultsMonitorings)) {
                    $monitoring['monitoring'] = array_merge($defaultsMonitorings, $monitoring['monitoring']);
                }
                $monitorings[$monitoringKey] = $monitoring;
            }
            $mergedConfig[$key]['monitorings'] = $monitorings;
        }

        return ['phash' => ['active_monitoring' => $mergedConfig]];
    }
}
