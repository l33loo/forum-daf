<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Question;

use App\Domain\Question;
use App\Domain\Question\QuestionRepository;
use Slick\Event\EventDispatcher;

/**
 * ChangeQuestionHandler
 *
 * @package App\Application\Question
 */
final readonly class ChangeQuestionHandler
{
    public function __construct(
        private QuestionRepository $questions,
        private EventDispatcher $dispatcher
    ) {
    }

    public function handle(ChangeQuestionCommand $command): Question
    {
        $question = $this->questions->withId($command->questionId());
        $this->dispatcher->dispatchEventsFrom(
            $question->change($command->question(), $command->body())
        );

        return $question;
    }
}