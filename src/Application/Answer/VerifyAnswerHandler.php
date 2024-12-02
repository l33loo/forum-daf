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
use App\Domain\Answer\Specification\AcceptableAnswerSpecification;
use Slick\Event\EventDispatcher;

/**
 * VerifyAnswerHandler
 *
 * @package App\Application\Answer
 */
final readonly class VerifyAnswerHandler
{


    public function __construct(
        private AnswerRepository $answers,
        private AcceptableAnswerSpecification $acceptable,
        private EventDispatcher $dispatcher
    ) {
    }

    /**
     * @throws DomainException
     */
    public function handle(VerifyAnswerCommand $command): Answer
    {
        $answer = $this->answers->withId($command->answerId());
        if ($this->acceptable->isSatisfiedBy($answer)) {
            $this->dispatcher->dispatchEventsFrom($answer->accept());
            return $answer;
        }

        $this->dispatcher->dispatchEventsFrom($answer->reject($this->acceptable->reason()));
        return $answer;
    }


}
