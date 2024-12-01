<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Event\Question;

use App\Domain\Question\QuestionId;
use App\Domain\Tag;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * TagWasAdded
 *
 * @package App\Domain\Event\Question
 */
final class TagWasAdded extends AbstractEvent implements Event, \JsonSerializable
{
    public function __construct(
        private readonly QuestionId $questionId,
        private readonly Tag $tag
    ) {
        parent::__construct();
    }

    public function questionId(): QuestionId
    {
        return $this->questionId;
    }

    public function tag(): Tag
    {
        return $this->tag;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'questionId' => $this->questionId,
            'tag' => [
                'tagId' => $this->tag->tagId(),
                'tag' => $this->tag->tag(),
            ],
        ];
    }
}