<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Answer;

use App\Application\Answer\VerifyAnswerCommand;
use App\Application\Answer\VerifyAnswerHandler;
use App\Domain\Answer;
use App\Domain\Answer\AnswerId;
use App\Domain\Answer\AnswerRepository;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;

/**
 * VerifyAnswerHandlerSpec specs
 *
 * @package spec\App\Application\Answer
 */
class VerifyAnswerHandlerSpec extends ObjectBehavior
{

    private $answerId;
    private $reason;

    function let(
        AnswerRepository $answers,
        Answer\Specification\AcceptableAnswerSpecification $acceptable,
        EventDispatcher $dispatcher,
        Answer $answer
    ) {
        $this->answerId = new AnswerId();
        $this->reason = 'some reason';
        $answers->withId($this->answerId)->willReturn($answer);

        $acceptable->isSatisfiedBy($answer)->willReturn(true);
        $answer->accept()->willReturn($answer);
        $answer->reject($this->reason)->willReturn($answer);

        $dispatcher->dispatchEventsFrom($answer)->willReturn([]);

        $this->beConstructedWith($answers, $acceptable, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(VerifyAnswerHandler::class);
    }

    function it_handles_verify_answer_command(Answer $answer, EventDispatcher $dispatcher)
    {
        $command = new VerifyAnswerCommand($this->answerId);

        $this->handle($command)->shouldBe($answer);

        $answer->accept()->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($answer)->shouldHaveBeenCalled();
    }

    function it_rejects_answer_when_acceptable_spec_fails(
        Answer\Specification\AcceptableAnswerSpecification $acceptable,
        Answer $answer
    ) {
        $acceptable->isSatisfiedBy($answer)->willReturn(false);
        $acceptable->reason()->willReturn($this->reason);

        $command = new VerifyAnswerCommand($this->answerId);

        $this->handle($command);

        $answer->reject($this->reason)->shouldHaveBeenCalled();
    }
}