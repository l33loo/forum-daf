<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Answer;

use App\Domain\DomainException;
use App\Domain\Answer;
use App\Domain\Answer\AnswerRepository;
use App\Domain\Comment;
use App\Domain\User\UserRepository;
use Slick\Event\EventDispatcher;

/**
 * AddAnswerCommentHandler
 *
 * @package App\Application\Answer
 */
final readonly class AddAnswerCommentHandler
{
    public function __construct(
        private AnswerRepository $answers,
        private UserRepository $users,
        private EventDispatcher $dispatcher
    ) {
    }

    /**
     * Handles adding a comment to an answer.
     *
     * @param AddAnswerCommentCommand $command The command object containing answerId and comment text
     * @return Answer The newly updated answer
     * @throws DomainException
     */
    public function handle(AddAnswerCommentCommand $command): Answer
    {
        $user = $this->users->withId($command->authorId());
        $comment = new Comment($user, $command->body());
        $answer = $this->answers->withId($command->answerId());

        $this->dispatcher->dispatchEventsFrom($answer->addComment($comment));

        return $answer;
    }
}