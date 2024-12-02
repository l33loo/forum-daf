<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Event\Comment;

use App\Domain\Comment\CommentId;
use DateTimeImmutable;
use JsonSerializable;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * CommentWasPublished
 *
 * @package App\Domain\Event\Comment
 */
final class CommentWasPublished extends AbstractEvent implements Event, JsonSerializable
{


    public function __construct(
        private readonly CommentId $commentId,
        private readonly DateTimeImmutable $publishedOn
    ) {
        parent::__construct();
    }

    /**
     * CommentWasPublished commentId
     *
     * @return CommentId
     */
    public function commentId(): CommentId
    {
        return $this->commentId;
    }

    /**
     * CommentWasPublished publishedOn
     *
     * @return DateTimeImmutable
     */
    public function publishedOn(): DateTimeImmutable
    {
        return $this->publishedOn;
    }

    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'commentId' => $this->commentId,
            'publishedOn' => $this->publishedOn,
        ];
    }
}
