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
use App\Domain\Tag\TagRepository;
use Slick\Event\EventDispatcher;

/**
 * AddQuestionTagHandler
 *
 * @package App\Application\Question
 */
final readonly class RemoveQuestionTagHandler
{


    public function __construct(
        private QuestionRepository $questions,
        private EventDispatcher $dispatcher
    ) {
    }

    /**
     * Handles remove a question's tag.
     *
     * @param RemoveQuestionTagCommand $command The command object containing the questionId
     * @return Question The newly updated question
     * @throws DomainException
     */
    public function handle(RemoveQuestionTagCommand $command): Question
    {
        $question = $this->questions->withId($command->questionId());
        $this->dispatcher->dispatchEventsFrom($question->removeTag($command->tag()));
        return $question;
    }


}