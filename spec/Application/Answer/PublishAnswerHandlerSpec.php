<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Answer;

use App\Application\Answer\PublishAnswerCommand;
use App\Application\Answer\PublishAnswerHandler;
use App\Domain\Answer;
use App\Domain\Answer\AnswerId;
use App\Domain\Answer\AnswerRepository;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;

/**
 * PublishAnswerHandlerSpec specs
 *
 * @package spec\App\Application\Answer
 */
class PublishAnswerHandlerSpec extends ObjectBehavior
{
    private $answerId;

    function let(
        AnswerRepository $answers,
        EventDispatcher $dispatcher,
        Answer $answer
    ) {
        $this->answerId = new AnswerId();
        $answers->withId($this->answerId)->willReturn($answer);
        $answer->publish()->willReturn($answer);

        $dispatcher->dispatchEventsFrom($answer)->willReturn([]);

        $this->beConstructedWith($answers, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PublishAnswerHandler::class);
    }

    function it_handles_publish_answer_command(
        EventDispatcher $dispatcher,
        Answer $answer
    ) {
        $command = new PublishAnswerCommand($this->answerId);
        $this->handle($command)->shouldBe($answer);
        $answer->publish()->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($answer)->shouldHaveBeenCalled();
    }
}