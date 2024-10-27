<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Question;

use App\Application\Question\VerifyQuestionCommand;
use App\Application\Question\VerifyQuestionHandler;
use App\Domain\Question;
use App\Domain\Question\QuestionId;
use App\Domain\Question\QuestionRepository;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;

/**
 * VerifyQuestionHandlerSpec specs
 *
 * @package spec\App\Application\Question
 */
class VerifyQuestionHandlerSpec extends ObjectBehavior
{

    private $questionId;
    private $reason;

    function let(
        QuestionRepository $questions,
        Question\Specification\AcceptableQuestionSpecification $acceptable,
        EventDispatcher $dispatcher,
        Question $question
    ) {
        $this->questionId = new QuestionId();
        $this->reason = 'some reason';
        $questions->withId($this->questionId)->willReturn($question);

        $acceptable->isSatisfiedBy($question)->willReturn(true);
        $question->accept()->willReturn($question);
        $question->reject($this->reason)->willReturn($question);

        $dispatcher->dispatchEventsFrom($question)->willReturn([]);

        $this->beConstructedWith($questions, $acceptable, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(VerifyQuestionHandler::class);
    }

    function it_handles_verify_question_command(Question $question, EventDispatcher $dispatcher)
    {
        $command = new VerifyQuestionCommand($this->questionId);

        $this->handle($command)->shouldBe($question);

        $question->accept()->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($question)->shouldHaveBeenCalled();
    }

    function it_rejects_question_when_acceptable_spec_fails(
        Question\Specification\AcceptableQuestionSpecification $acceptable,
        Question $question
    ) {
        $acceptable->isSatisfiedBy($question)->willReturn(false);
        $acceptable->reason()->willReturn($this->reason);

        $command = new VerifyQuestionCommand($this->questionId);

        $this->handle($command);

        $question->reject($this->reason)->shouldHaveBeenCalled();
    }
}