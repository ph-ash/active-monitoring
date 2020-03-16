<?php

declare(strict_types=1);

namespace App\Processor;

use Buzz\Browser;
use Enqueue\Client\TopicSubscriberInterface;
use Interop\Queue\Context;
use Interop\Queue\Message;
use Interop\Queue\Processor;

class ScheduleProcessor implements Processor, TopicSubscriberInterface
{
    public const MONITORING_KEY = 'monitoring.key';
    public const CONNECTOR_NAME = 'connector.name';
    public const CONNECTOR_NAME_HEADER = 'X-Connector-Name';

    private $client;

    public function __construct(Browser $client)
    {
        $this->client = $client;
    }

    public static function getSubscribedTopics()
    {
        return [
            'schedule'
        ];
    }

    public function process(Message $message, Context $context)
    {
        $this->client->post(
            'https://localhost:8000/execute/' . urlencode($message->getProperty(self::MONITORING_KEY)), # TODO: inject url
            ['Content-Type' => 'application/json', self::CONNECTOR_NAME_HEADER => $message->getProperty(self::CONNECTOR_NAME)],
            $message->getBody()
        );

        return self::ACK;
    }
}
