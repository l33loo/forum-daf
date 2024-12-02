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
use App\Domain\Post\PostId;
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
     * @param PostId $postId The ID of the post (question or answer).
     * @param CommentId $commentId The ID of the comment.
     * @param UserId $authorId The ID of the author who posted the comment.
     * @param string $body The body text of the comment.
     */
    public function __construct(
        private readonly PostId $postId,
        private readonly CommentId $commentId,
        private readonly UserId $authorId,
        private readonly string $body
    ) {
        parent::__construct();
    }

    /**
     * CommentWasAdded postId
     *
     * @return PostId
     */
    public function postId(): PostId
    {
        return $this->postId;
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
     * CommentWasAdded authorId
     *
     * @return UserId
     */
    public function authorId(): UserId
    {
        return $this->authorId;
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
            'postId' => $this->postId,
            'commentId' => $this->commentId,
            'authorId' => $this->authorId,
            'body' => $this->body,
        ];
    }
}
