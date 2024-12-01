<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\App\Application\Question;

use App\Application\Question\ChangeQuestionCommand;
use App\Application\Question\ChangeQuestionHandler;
use App\Domain\Question;
use App\Domain\Question\QuestionRepository;
use App\Domain\User;
use App\Domain\User\Email;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;

/**
 * ChangeQuestionHandlerSpec specs
 *
 * @package spec\App\Application\Question
 */
class ChangeQuestionHandlerSpec extends ObjectBehavior
{
    private Question $question;

    function let(
        QuestionRepository $questions,
        EventDispatcher $dispatcher
    ) {
        $user = new User(new Email('user@email.com'));
        $this->question = new Question($user, "Question?", "Body...");
        $questions->withId($this->question->questionId())->willReturn($this->question);
        $dispatcher->dispatchEventsFrom(Argument::type(Question::class))->willReturn([]);

        $this->beConstructedWith($questions, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ChangeQuestionHandler::class);
    }

    function it_handles_change_question_command(
        EventDispatcher $dispatcher
    ) {
        $command = new ChangeQuestionCommand(
            $this->question->questionId(),
            "Changed Question?",
            "Changed body..."
        );
        $this->handle($command)->shouldBe($this->question);
        $dispatcher->dispatchEventsFrom($this->question)->shouldHaveBeenCalled();
    }
}