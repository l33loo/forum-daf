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
 * PublishQuestionHandler
 *
 * @package App\Application\Question
 */
final readonly class PublishQuestionHandler
{


    public function __construct(
        private QuestionRepository $questions,
        private EventDispatcher $eventDispatcher
    ) {
    }

    public function handle(PublishQuestionCommand $command): Question
    {
        $question = $this->questions->withId($command->questionId());
        $this->eventDispatcher->dispatchEventsFrom($question->publish());
        return $question;
    }


}
