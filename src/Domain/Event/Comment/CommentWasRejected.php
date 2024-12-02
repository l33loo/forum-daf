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
use JsonSerializable;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * CommentWasRejected
 *
 * @package App\Domain\Event\Comment
 */
final class CommentWasRejected extends AbstractEvent implements Event, JsonSerializable
{


    /**
     * Creates a CommentWasRejected
     *
     * @param CommentId $commentId
     */
    public function __construct(
        private readonly CommentId $commentId,
        private readonly string $rejectReason,
    ) {
        parent::__construct();
    }

    /**
     * CommentWasRejected CommentId
     *
     * @return CommentId
     */
    public function commentId(): CommentId
    {
        return $this->commentId;
    }

    /**
     * CommentWasRejected rejectReason
     *
     * @return string
     */
    public function rejectReason(): string
    {
        return $this->rejectReason;
    }

    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'rejectReason' => $this->rejectReason,
            'commentId' => $this->commentId,
        ];
    }
}
