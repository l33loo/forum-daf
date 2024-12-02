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
use App\Domain\User\UserId;
use JsonSerializable;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * CommentWasAdded
 *
 * @package App\Domain\Events\Comment
 */
final class CommentWasAdded extends AbstractEvent implements Event, JsonSerializable
{


    /**
     * Creates a CommentWasAdded
     *
     * @param CommentId $commentId The ID of the comment.
     * @param UserId $userId The ID of the user who posted the comment.
     * @param string $body The body text of the comment.
     */
    public function __construct(
        private readonly CommentId $commentId,
        private readonly UserId $userId,
        private readonly string $body
    ) {
        parent::__construct();
    }

    /**
     * CommentWasAdded commentId
     *
     * @return CommentId
     */
    public function commentId(): CommentId
    {
        return $this->commentId;
    }

    /**
     * CommentWasAdded userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * CommentWasAdded body
     *
     * @return string
     */
    public function body(): string
    {
        return $this->body;
    }

    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'commentId' => $this->commentId,
            'userId' => $this->userId,
            'body' => $this->body,
        ];
    }
}
