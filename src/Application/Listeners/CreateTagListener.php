<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Listeners;

use App\Application\Tag\CreateTagCommand;
use App\Application\Tag\CreateTagHandler;
use App\Domain\Event\Question\TagWasAdded;
use App\Domain\Tag\TagRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * CreateTagListener
 *
 * @package App\Application\Listeners
 */
#[AsEventListener(event: TagWasAdded::class, method: 'onTagAdded')]
final readonly class CreateTagListener
{
    public function __construct(private CreateTagHandler $handler, private TagRepository $tags)
    {}

    public function onTagAdded(TagWasAdded $event): void
    {
        try {
            $this->tags->withTagText($event->tag()->tag());
        } catch (EntityNotFoundException) {
            $this->handler->handle(new CreateTagCommand($event->tag()->tag()));
        }
    }
}
