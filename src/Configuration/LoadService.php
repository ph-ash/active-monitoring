<?php

declare(strict_types=1);

namespace App\Configuration;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Yaml;

class LoadService implements Load
{
    private $merge;
    private $configuration;
    private $projectDirectory;

    public function __construct(Merge $merge, RootConfiguration $configuration, string $projectDirectory)
    {
        $this->merge = $merge;
        $this->configuration = $configuration;
        $this->projectDirectory = $projectDirectory;
    }

    public function load(): array
    {
        $configFromFile = Yaml::parseFile($this->projectDirectory . '/config/application/phash.yaml');
        $configWithDefaultsMerged = $this->merge->mergeDefaults($configFromFile);

        $processor = new Processor();
        return $processor->processConfiguration($this->configuration, $configWithDefaultsMerged);
    }
}
