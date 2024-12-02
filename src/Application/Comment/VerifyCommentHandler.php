<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Comment;

use App\Domain\DomainException;
use App\Domain\Comment;
use App\Domain\Comment\CommentRepository;
use App\Domain\Comment\Specification\AcceptableCommentSpecification;
use Slick\Event\EventDispatcher;

/**
 * VerifyCommentHandler
 *
 * @package App\Application\Comment
 */
final readonly class VerifyCommentHandler
{


    public function __construct(
        private CommentRepository $comments,
        private AcceptableCommentSpecification $acceptable,
        private EventDispatcher $dispatcher
    ) {
    }

    /**
     * @throws DomainException
     */
    public function handle(VerifyCommentCommand $command): Comment
    {
        $comment = $this->comments->withId($command->commentId());
        if ($this->acceptable->isSatisfiedBy($comment)) {
            $this->dispatcher->dispatchEventsFrom($comment->accept());
            return $comment;
        }

        $this->dispatcher->dispatchEventsFrom($comment->reject($this->acceptable->reason()));
        return $comment;
    }
}
