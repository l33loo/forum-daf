<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Tag;

use App\Domain\DomainException;
use App\Domain\Tag;
use App\Domain\Tag\TagRepository;
use Slick\Event\EventDispatcher;

/**
 * DeleteTagHandler
 *
 * @package App\Application\Tag
 */
final readonly class DeleteTagHandler
{
    

    public function __construct(
        private TagRepository $tags,
        private EventDispatcher $dispatcher
    ) {
    }

    /**
     * Handles deleting a tag.
     *
     * @param DeleteTagCommand $command The command object containing tagId
     * @return Tag The newly deleted tag
     * @throws DomainException
     */
    public function handle(DeleteTagCommand $command): Tag
    {
        $tag = $this->tags->withId($command->tagId());
        $this->dispatcher->dispatchEventsFrom($tag->remove());
        return $tag;
    }
}