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
use App\Domain\Exception\EntityNotFound;
use App\Domain\Question;
use App\Domain\Question\QuestionRepository;
use App\Domain\Tag;
use App\Domain\Tag\TagRepository;
use Slick\Event\EventDispatcher;

/**
 * AddQuestionTagHandler
 *
 * @package App\Application\Question
 */
final readonly class AddQuestionTagHandler
{


    public function __construct(
        private QuestionRepository $questions,
        private TagRepository $tags,
        private EventDispatcher $dispatcher
    ) {
    }

    /**
     * Handles adding a tag to a question.
     *
     * @param AddQuestionTagCommand $command The command object containing questionId and tag text
     * @return Question The newly updated question
     * @throws DomainException
     */
    public function handle(AddQuestionTagCommand $command): Question
    {
        $tag = null;
        try {
            $tag = $this->tags->withTagText($command->tag());
        } catch (EntityNotFound) {
            $tag = new Tag($command->tag());
        }

        $question = $this->questions->withId($command->questionId());
        $this->dispatcher->dispatchEventsFrom($question->addTag($tag));
        return $question;
    }


}