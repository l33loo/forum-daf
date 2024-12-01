<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Question;

use App\Application\Question\RemoveQuestionCommand;
use App\Application\Question\RemoveQuestionHandler;
use App\Domain\Question;
use App\Domain\Question\QuestionId;
use App\Domain\Question\QuestionRepository;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;

/**
 * RemoveQuestionHandlerSpec specs
 *
 * @package spec\App\Application\Question
 */
class RemoveQuestionHandlerSpec extends ObjectBehavior
{
    private $questionId;

    function let(
        QuestionRepository $questions,
        EventDispatcher $dispatcher,
        Question $question
    ) {
        $this->questionId = new QuestionId();
        $questions->withId($this->questionId)->willReturn($question);
        $questions->delete($question)->willReturn($question);

        $dispatcher->dispatchEventsFrom($question)->willReturn([]);

        $this->beConstructedWith($questions, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RemoveQuestionHandler::class);
    }

    function it_handles_remove_question_command(
        EventDispatcher $dispatcher,
        Question $question
    ) {
        $command = new RemoveQuestionCommand($this->questionId);
        $this->handle($command)->shouldBe($question);
        $dispatcher->dispatchEventsFrom($question)->shouldHaveBeenCalled();
    }
}