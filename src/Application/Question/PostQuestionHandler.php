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
use App\Domain\User\UserRepository;
use Slick\Event\EventDispatcher;

/**
 * PostQuestionHandler
 *
 * @package App\Application\Question
 */
final readonly class PostQuestionHandler
{


    public function __construct(
        private UserRepository $users,
        private QuestionRepository $questions,
        private EventDispatcher $dispatcher
    ) {
    }

    /**
     * Handles posting a new question.
     *
     * @param PostQuestionCommand $command The command object containing question details
     * @return Question The newly created question
     * @throws DomainException
     */
    public function handle(PostQuestionCommand $command): Question
    {
        $user = $this->users->withId($command->userId());
        $question = new Question($user, $command->question(), $command->body());
        $this->dispatcher->dispatchEventsFrom(
            $this->questions->add($question)
        );
        return $question;
    }
}
