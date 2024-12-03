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
use App\Domain\Answer\AnswerId;
use App\Domain\Answer\AnswerRepository;
use App\Domain\Question;
use App\Domain\Question\QuestionId;
use App\Domain\Question\QuestionRepository;
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
    private $questionId;
    private $answer;
    private $user;

    function let(
        UserRepository $users,
        AnswerRepository $answers,
        EventDispatcher $dispatcher,
        User $user,
        QuestionRepository $questions,
        Question $question
    ) {
        $this->userId = new UserId();
        $this->questionId = new QuestionId();
        $this->user = new User(new User\Email('user@email.com'));

        $users->withId($this->userId)->willReturn($this->user);
        $user->userId()->willReturn($this->userId);

        $questions->withId($this->questionId)->willReturn($question);
        $question->addAnswer(Argument::type(Answer::class))->willReturn($question);

        $answers->add(Argument::type(Answer::class))->willReturnArgument();

        $dispatcher->dispatchEventsFrom(Argument::type(Answer::class))->willReturn([]);

        $this->beConstructedWith($users, $answers, $questions, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GiveAnswerHandler::class);
    }

    function it_handles_give_answer_command(
        AnswerRepository $answers,
        EventDispatcher $dispatcher,
        Question $question
    ) {
        $command = new GiveAnswerCommand($this->userId, $this->questionId, "Some body...");
        $answer = $this->handle($command);
        $answer->shouldBeAnInstanceOf(Answer::class);
        $answers->add($answer)->shouldHaveBeenCalled();
        $question->addAnswer($answer)->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($answer)->shouldHaveBeenCalled();
    }
}