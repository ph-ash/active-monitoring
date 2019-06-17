<?php

declare(strict_types=1);

namespace App\Controller;

use App\Configuration\DTO\MonitoringConfiguration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class JsonBodyConverter implements ParamConverterInterface
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $name = $configuration->getName();
        $content = $request->getContent();
        $object = $this->serializer->deserialize($content, $configuration->getClass(), JsonEncoder::FORMAT);
        $request->attributes->set($name, $object);
        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === MonitoringConfiguration::class;
    }
}
