<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Question;

use App\Domain\DomainException;
use App\Domain\Question;
use App\Domain\Question\QuestionRepository;
use App\Domain\Comment;
use App\Domain\User\UserRepository;
use Slick\Event\EventDispatcher;

/**
 * AddQuestionCommentHandler
 *
 * @package App\Application\Question
 */
final readonly class AddQuestionCommentHandler
{
    public function __construct(
        private QuestionRepository $questions,
        private UserRepository $users,
        private EventDispatcher $dispatcher
    ) {
    }

    /**
     * Handles adding a comment to an question.
     *
     * @param AddQuestionCommentCommand $command The command object containing questionId and comment text
     * @return Question The newly updated question
     * @throws DomainException
     */
    public function handle(AddQuestionCommentCommand $command): Question
    {
        $user = $this->users->withId($command->authorId());
        $comment = new Comment($user, $command->body());
        $question = $this->questions->withId($command->questionId());

        $this->dispatcher->dispatchEventsFrom($question->addComment($comment));

        return $question;
    }
}