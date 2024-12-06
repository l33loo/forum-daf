<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\App\Application\Answer;

use App\Application\Answer\VoteAnswerCommand;
use App\Application\Answer\VoteAnswerHandler;
use App\Domain\Answer;
use App\Domain\Answer\AnswerId;
use App\Domain\Answer\AnswerRepository;
use App\Domain\Exception\EntityNotFound;
use App\Domain\User;
use App\Domain\User\UserId;
use App\Domain\User\UserRepository;
use App\Domain\Vote;
use App\Domain\Vote\VoteRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;

/**
 * VoteAnswerHandlerSpec specs
 *
 * @package spec\App\Application\Answer
 */
class VoteAnswerHandlerSpec extends ObjectBehavior
{
    private AnswerId $answerId;
    private UserId $userId;
    private bool $intention;

    function let(
        Vote $vote,
        Answer $answer,
        User $user,
        VoteRepository $votes,
        AnswerRepository $answers,
        UserRepository $users,
        EventDispatcher $dispatcher
    ) {
        $this->userId = new UserId();
        $this->answerId = new AnswerId();
        $this->intention = true;
        $votes->withAnswerIdAndUserId(
            $this->answerId,
            $this->userId
        )->willThrow(EntityNotFound::class);
        $votes->add(Argument::type(Vote::class))->willReturn($vote);
        $answers->withId($this->answerId)->willReturn($answer);
        $answer->addVote(Argument::type(Vote::class))->willReturn($answer);
        $users->withId($this->userId)->willReturn($user);
        $vote->user()->willReturn($user);
        $dispatcher->dispatchEventsFrom(Argument::type(Answer::class))->willReturn([]);

        $this->beConstructedWith($votes, $answers, $users, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(VoteAnswerHandler::class);
    }

    function it_handles_vote_answer_command_with_new_vote(
        Answer $answer,
        VoteRepository $votes,
        EventDispatcher $dispatcher
    ) {
        $command = new VoteAnswerCommand(
            $this->answerId,
            $this->userId,
            $this->intention
        );
        $this->handle($command)->shouldBe($answer);
        $votes->add(Argument::type(Vote::class))->shouldHaveBeenCalled();
        $answer->addVote(Argument::type(Vote::class))->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($answer)->shouldHaveBeenCalled();
    }

    function it_handles_vote_answer_command_with_existing_vote(
        Vote $vote,
        Answer $answer,
        VoteRepository $votes,
        EventDispatcher $dispatcher
    ) {
        $votes->withAnswerIdAndUserId(
            $this->answerId,
            $this->userId
        )->willReturn($vote);

        $command = new VoteAnswerCommand(
            $this->answerId,
            $this->userId,
            $this->intention
        );
        $this->handle($command)->shouldBe($answer);
        $votes->add($vote)->shouldNotHaveBeenCalled();
        $answer->addVote($vote)->shouldNotHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($answer)->shouldNotHaveBeenCalled();
    }
}