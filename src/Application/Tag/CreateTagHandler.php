<?php

declare(strict_types=1);

namespace App\Application\Tag;

use App\Domain\DomainException;
use App\Domain\Tag;
use App\Domain\Tag\TagRepository;
use Slick\Event\EventDispatcher;

/**
 * CreateTagHandler
 *
 * @package App\Application\Tag
 */
final readonly class CreateTagHandler
{
    public function __construct(
        private TagRepository $tags,
        private EventDispatcher $dispatcher
    ) {
    }

    /**
     * Handles posting a new tag.
     *
     * @param CreateTagCommand $command The command object containing tag details
     * @return Tag The newly created tag
     * @throws DomainException
     */
    public function handle(CreateTagCommand $command): Tag
    {
        $tag = new Tag($command->tag());
        $this->dispatcher->dispatchEventsFrom(
            $this->tags->add($tag)
        );
        return $tag;
    }
}