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
use spec\App\Domain\Question\Specification\AcceptableQuestionSpecificationSpec;

/**
 * VerifyTagHandler
 *
 * @package App\Application\Tag
 */
final readonly class VerifyTagHandler
{
    public function __construct(
        private TagRepository $tags,
        private AcceptableTagSpecification $acceptable,
        private EventDispatcher $dispatcher
    ) {
    }

    /**
     * @throws DomainException
     */
    public function handle(VerifyTagCommand $command): Tag
    {
        $tag = $this->tags->withId($command->tagId());
        if ($this->acceptable->isSatisfiedBy($tag)) {
            $this->dispatcher->dispatchEventsFrom($tag->accept());
            return $tag;
        }

        $this->dispatcher->dispatchEventsFrom($tag->reject($this->acceptable->reason()));
        return $tag;
    }
}