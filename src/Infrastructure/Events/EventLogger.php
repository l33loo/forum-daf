<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Events;

use JsonSerializable;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Slick\Event\Event;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;


/**
 * EventLogger
 *
 * @package App\Infrastructure\Events
 */
#[WithMonologChannel('domain events')]
#[AsEventListener(event: Event::class, method: "onEvent")]
final readonly class EventLogger
{
    public function __construct(
        private LoggerInterface $logger
    ) {

    }

    public function onEvent(object $event): void
    {
        if ($event instanceof Event) {
            $this->process($event);
        }
    }

    private function process(Event $event): void
    {
        $message = $this->parseEventName($event);
        $context = [];
        if ($event instanceof JsonSerializable) {
            $context = (array) json_decode(json_encode($event));
        }

        $this->logger->info($message, $context);
    }

    /**
     * Parse event name from its class name
     *
     * @param Event $event
     * @return string
     */
    private function parseEventName(Event $event): string
    {
        $parts = explode("\\", get_class($event));
        $name = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', end($parts)));
        return ucfirst(str_replace('_', ' ', $name));
    }
}
