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
use App\Domain\Question\Specification\AcceptableQuestionSpecification;
use Slick\Event\EventDispatcher;

/**
 * VerifyQuestionHandler
 *
 * @package App\Application\Question
 */
final readonly class VerifyQuestionHandler
{


    public function __construct(
        private QuestionRepository $questions,
        private AcceptableQuestionSpecification $acceptable,
        private EventDispatcher $dispatcher
    ) {
    }

    /**
     * @throws DomainException
     */
    public function handle(VerifyQuestionCommand $command): Question
    {
        $question = $this->questions->withId($command->questionId());
        if ($this->acceptable->isSatisfiedBy($question)) {
            $this->dispatcher->dispatchEventsFrom($question->accept());
            return $question;
        }

        $this->dispatcher->dispatchEventsFrom($question->reject($this->acceptable->reason()));
        return $question;
    }


}
