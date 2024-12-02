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
 * RemoveQuestionHandler
 *
 * @package App\Application\Question
 */
final readonly class RemoveQuestionHandler
{


    public function __construct(
        private QuestionRepository $questions,
        private EventDispatcher $eventDispatcher
    ) {
    }

    public function handle(RemoveQuestionCommand $command): Question
    {
        $question = $this->questions->withId($command->questionId());
        $this->eventDispatcher->dispatchEventsFrom(
            $this->questions->delete($question)
        );
        return $question;
    }
}
