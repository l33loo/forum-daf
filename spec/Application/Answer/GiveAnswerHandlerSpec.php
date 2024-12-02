<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Answer;

use App\Application\Answer\GiveAnswerCommand;
use App\Application\Answer\GiveAnswerHandler;
use App\Domain\Answer;
use App\Domain\Answer\AnswerRepository;
use App\Domain\User;
use App\Domain\User\UserId;
use App\Domain\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;

/**
 * GiveAnswerHandlerSpec specs
 *
 * @package spec\App\Application\Answer
 */
class GiveAnswerHandlerSpec extends ObjectBehavior
{

    private $userId;

    function let(
        UserRepository $users,
        AnswerRepository $answers,
        EventDispatcher $dispatcher,
        User $user
    ) {
        $this->userId = new UserId();

        $users->withId($this->userId)->willReturn($user);
        $user->userId()->willReturn($this->userId);

        $answers->add(Argument::type(Answer::class))->willReturnArgument();

        $dispatcher->dispatchEventsFrom(Argument::type(Answer::class))->willReturn([]);

        $this->beConstructedWith($users, $answers, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GiveAnswerHandler::class);
    }

    function it_handle_post_answer_command(
        AnswerRepository $answers,
        EventDispatcher $dispatcher
    ) {
        $command = new GiveAnswerCommand($this->userId, "Some body...");
        $answer = $this->handle($command);
        $answer->shouldBeAnInstanceOf(Answer::class);
        $answers->add($answer)->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($answer)->shouldHaveBeenCalled();
    }
}