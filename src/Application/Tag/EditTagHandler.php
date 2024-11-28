<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Tag;

use App\Domain\Tag;
use App\Domain\Tag\TagRepository;
use Slick\Event\EventDispatcher;

/**
 * EditTagHandler
 *
 * @package App\Application\Tag
 */
final readonly class EditTagHandler
{


    public function __construct(
        private TagRepository $tags,
        private EventDispatcher $dispatcher
    ) {
    }

    public function handle(EditTagCommand $command): Tag
    {
        $tag = $this->tags->withId($command->tagId());
        $this->dispatcher->dispatchEventsFrom(
            $tag->edit($command->tag())
        );

        return $tag;
    }
}