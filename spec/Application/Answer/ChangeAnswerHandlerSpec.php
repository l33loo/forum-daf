<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\App\Application\Answer;

use App\Application\Answer\ChangeAnswerCommand;
use App\Application\Answer\ChangeAnswerHandler;
use App\Domain\Answer;
use App\Domain\Answer\AnswerRepository;
use App\Domain\Question;
use App\Domain\Question\QuestionId;
use App\Domain\User;
use App\Domain\User\Email;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;

/**
 * ChangeAnswerHandlerSpec specs
 *
 * @package spec\App\Application\Answer
 */
class ChangeAnswerHandlerSpec extends ObjectBehavior
{
    private Answer $answer;
    private Question $question;

    function let(
        AnswerRepository $answers,
        EventDispatcher $dispatcher
    ) {
        $user = new User(new Email('user@email.com'));
        $this->question = new Question($user, 'Question?', 'Question body...');
        $this->answer = new Answer($user, "Body...", $this->question);
        $answers->withId($this->answer->answerId())->willReturn($this->answer);
        $dispatcher->dispatchEventsFrom(Argument::type(Answer::class))->willReturn([]);

        $this->beConstructedWith($answers, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ChangeAnswerHandler::class);
    }

    function it_handles_change_answer_command(
        EventDispatcher $dispatcher
    ) {
        $command = new ChangeAnswerCommand(
            $this->answer->answerId(),
            "Changed body..."
        );
        $this->handle($command)->shouldBe($this->answer);
        $dispatcher->dispatchEventsFrom($this->answer)->shouldHaveBeenCalled();
    }
}