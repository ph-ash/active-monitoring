<?php

declare(strict_types=1);

namespace App\Configuration;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Yaml;

class LoadService implements Load
{
    private $merge;
    private $configuration;

    public function __construct(Merge $merge, RootConfiguration $configuration)
    {
        $this->merge = $merge;
        $this->configuration = $configuration;
    }

    public function load(): array
    {
        $configFromFile = Yaml::parseFile('config/application/phash.yaml');
        $configWithDefaultsMerged = $this->merge->mergeDefaults($configFromFile);

        $processor = new Processor();
        return $processor->processConfiguration($this->configuration, $configWithDefaultsMerged);
    }
}
