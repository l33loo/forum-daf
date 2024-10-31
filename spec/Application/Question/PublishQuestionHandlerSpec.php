<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Question;

use App\Application\Question\PublishQuestionCommand;
use App\Application\Question\PublishQuestionHandler;
use App\Domain\Question;
use App\Domain\Question\QuestionId;
use App\Domain\Question\QuestionRepository;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;

/**
 * PublishQuestionHandlerSpec specs
 *
 * @package spec\App\Application\Question
 */
class PublishQuestionHandlerSpec extends ObjectBehavior
{
    private $questionId;

    function let(
        QuestionRepository $questions,
        EventDispatcher $dispatcher,
        Question $question
    ) {
        $this->questionId = new QuestionId();
        $questions->withId($this->questionId)->willReturn($question);
        $question->publish()->willReturn($question);

        $dispatcher->dispatchEventsFrom($question)->willReturn([]);

        $this->beConstructedWith($questions, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PublishQuestionHandler::class);
    }

    function it_handles_publish_question_command(
        EventDispatcher $dispatcher,
        Question $question
    ) {
        $command = new PublishQuestionCommand($this->questionId);
        $this->handle($command)->shouldBe($question);
        $question->publish()->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($question)->shouldHaveBeenCalled();
    }
}