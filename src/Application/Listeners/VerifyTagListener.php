<?php
declare(strict_types=1);

namespace App\Application\Listeners;

use App\Domain\Event\Tag\TagWasCreated;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * VerifyTagListener
 *
 * @package App\Application\Listeners
 */
#[AsEventListener(event: TagWasCreated::class, method: 'onTagCreated')]
final readonly class VerifyTagListener
{
    public function __construct(private VerifyTagHandler $handler)
    {
    }

    public function onTagCreated(TagWasCreated $event): void
    {
        $this->handler->handle(
            new VerifyTagCommand($event->tagId())
        );
    }
}