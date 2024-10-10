<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Events;

use Slick\Event\Event;
use Slick\Event\EventDispatcher;
use Slick\Event\EventGenerator;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * DomainEventDispatcher
 *
 * @package App\Infrastructure\Events
 */
final class DomainEventDispatcher implements EventDispatcher
{
    private array $registered = [];

    /**
     * Creates a DomainEventDispatcher
     *
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(private readonly EventDispatcherInterface $dispatcher)
    {
    }

    /**
     * @inheritDoc
     */
    public function dispatchEventsFrom(EventGenerator $generator): array
    {
        $events = $generator->releaseEvents();
        foreach ($events as $event) {
            $this->dispatch($event);
        }

        return $events;
    }

    /**
     * @inheritDoc
     */
    public function addListener(string $event, $listener, int $priority = EventDispatcher::P_NORMAL): void
    {
        $this->dispatcher->addListener($event, $listener, $priority);
    }

    /**
     * @inheritDoc
     */
    public function dispatch(object $event): void
    {
        if ($this->dispatcher->hasListeners(Event::class)) {
            $this->registerGenericListener($event);
        }

        $this->dispatcher->dispatch($event);
    }

    private function registerGenericListener(object $event): void
    {
        $eventName = $event::class;
        $genericListeners = $this->dispatcher->getListeners(Event::class);
        if (in_array($eventName, $this->registered)) {
            return;
        }

        foreach ($genericListeners as $listener) {
            $this->addListener($eventName, $listener);
        }
    }
}
