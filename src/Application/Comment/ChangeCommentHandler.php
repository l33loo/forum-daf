<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Comment;

use App\Domain\Comment;
use App\Domain\Comment\CommentRepository;
use Slick\Event\EventDispatcher;

/**
 * ChangeCommentHandler
 *
 * @package App\Application\Comment
 */
final readonly class ChangeCommentHandler
{
    public function __construct(
        private CommentRepository $comments,
        private EventDispatcher $dispatcher
    ) {
    }

    public function handle(ChangeCommentCommand $command): Comment
    {
        $comment = $this->comments->withId($command->commentId());
        $this->dispatcher->dispatchEventsFrom(
            $comment->change($command->body())
        );

        return $comment;
    }
}