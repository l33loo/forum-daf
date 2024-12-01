<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Listeners;

use App\Application\Tag\DeleteTagCommand;
use App\Application\Tag\DeleteTagHandler;
use App\Domain\Event\Question\TagWasRemoved;
use App\Domain\Event\Tag\TagWasRejected;
use App\Domain\Tag\TagRepository;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * DeleteTagListener
 *
 * @package App\Application\Listeners
 */
#[AsEventListener(event: TagWasRejected::class, method: 'onTagRejected')]
#[AsEventListener(event: TagWasRemoved::class, method: 'onTagRemoved')]
final readonly class DeleteTagListener
{
    public function __construct(
        private DeleteTagHandler $handler,
        private TagRepository $tags,
    ) {}

    public function onTagRejected(TagWasRejected $event): void
    {
        $this->handler->handle(new DeleteTagCommand($event->tagId()));
    }

    public function onTagRemoved(TagWasRejected $event): void
    {
        $tag = $this->tags->withId($event->tagId());
        if ($tag->questions()->count() === 0) {
            $this->handler->handle(new DeleteTagCommand($event->tagId()));
        }
    }
}
