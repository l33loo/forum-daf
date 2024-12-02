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
use App\Domain\User\UserRepository;
use Slick\Event\EventDispatcher;

/**
 * GiveAnswerHandler
 *
 * @package App\Application\Answer
 */
final readonly class GiveAnswerHandler
{


    public function __construct(
        private UserRepository $users,
        private AnswerRepository $answers,
        private EventDispatcher $dispatcher
    ) {
    }

    /**
     * Handles posting a new answer.
     *
     * @param GiveAnswerCommand $command The command object containing answer details
     * @return Answer The newly created answer
     * @throws DomainException
     */
    public function handle(GiveAnswerCommand $command): Answer
    {
        $user = $this->users->withId($command->userId());
        $answer = new Answer($user, $command->body());
        $this->dispatcher->dispatchEventsFrom(
            $this->answers->add($answer)
        );
        return $answer;
    }
}
