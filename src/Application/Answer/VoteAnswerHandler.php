<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Answer;

use App\Domain\Answer;
use App\Domain\Answer\AnswerRepository;
use App\Domain\Vote;
use App\Domain\Vote\VoteRepository;
use Doctrine\ORM\EntityNotFoundException;
use League\Bundle\OAuth2ServerBundle\Repository\UserRepository;
use Slick\Event\EventDispatcher;

/**
 * VoteAnswerHandler
 *
 * @package App\Application\Answer
 */
final readonly class VoteAnswerHandler
{
    public function __construct(
        private VoteRepository $votes,
        private AnswerRepository $answers,
        private UserRepository $users,
        private EventDispatcher $dispatcher
    ) {
    }

    public function handle(VoteAnswerCommand $command): Answer
    {
        $answer = null;
        try {
            $this->votes->withAnswerIdAndUserId($command->answerId(), $command->userId());
        } catch (EntityNotFoundException $e) {
            $answer = $this->answers->withId($command->answerId());
            $user = $this->users->withId($command->userId());
            $vote = new Vote($answer, $user, $command->intention());
            $this->votes->add($vote);
            $this->dispatcher->dispatchEventsFrom(
                $answer->addVote($vote)
            );
        }

        return $answer;
    }
}