<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Question;

use App\Application\Question\PostQuestionCommand;
use App\Application\Question\PostQuestionHandler;
use App\Domain\Question;
use App\Domain\Question\QuestionRepository;
use App\Domain\User;
use App\Domain\User\UserId;
use App\Domain\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;

/**
 * PostQuestionHandlerSpec specs
 *
 * @package spec\App\Application\Question
 */
class PostQuestionHandlerSpec extends ObjectBehavior
{

    private $userId;

    function let(
        UserRepository $users,
        QuestionRepository $questions,
        EventDispatcher $dispatcher,
        User $user
    ) {
        $this->userId = new UserId();

        $users->withId($this->userId)->willReturn($user);
        $user->userId()->willReturn($this->userId);

        $questions->add(Argument::type(Question::class))->willReturnArgument();

        $dispatcher->dispatchEventsFrom(Argument::type(Question::class))->willReturn([]);

        $this->beConstructedWith($users, $questions, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PostQuestionHandler::class);
    }

    function it_handle_post_question_command(
        QuestionRepository $questions,
        EventDispatcher $dispatcher
    ) {
        $command = new PostQuestionCommand($this->userId, "Why?", "Some body...");
        $question = $this->handle($command);
        $question->shouldBeAnInstanceOf(Question::class);
        $questions->add($question)->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($question)->shouldHaveBeenCalled();
    }
}