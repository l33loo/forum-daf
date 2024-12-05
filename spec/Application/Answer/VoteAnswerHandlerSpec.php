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
use App\Domain\Answer\AnswerRepository;
use App\Domain\Question;
use App\Domain\User;
use App\Domain\User\Email;
use App\Domain\User\UserRepository;
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
    private Answer $answer;
    private User $user1;
    private User $user2;
    private User $user3;
    private bool $intention;

    function let(
        VoteRepository $votes,
        EventDispatcher $dispatcher
    ) {
        $this->user1 = new User(new Email('user1@email.com'));
        $this->user2 = new User(new Email('user2@email.com'));
        $this->user3 = new User(new Email('user3@email.com'));
        $question = new Question($this->user1, 'Question?', 'Question body...');
        $this->answer = new Answer($this->user2, "Body...", $question);
        $this->intention = true;
        $votes->withAnswerIdAndUserId($this->answer->answerId(), $this->user3->userId())->willReturn($this->answer);
        $dispatcher->dispatchEventsFrom(Argument::type(Answer::class))->willReturn([]);

        $this->beConstructedWith($votes, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(VoteAnswerHandler::class);
    }

    function it_handles_vote_answer_command(
        EventDispatcher $dispatcher
    ) {
        $command = new VoteAnswerCommand(
            $this->answer->answerId(),
            $this->user3->userId(),
            $this->intention
        );
        $this->handle($command)->shouldBe($this->answer);
        $dispatcher->dispatchEventsFrom($this->answer)->shouldHaveBeenCalled();
    }
}