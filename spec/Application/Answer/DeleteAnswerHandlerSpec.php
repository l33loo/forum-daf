<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Answer;

use App\Application\Answer\DeleteAnswerCommand;
use App\Application\Answer\DeleteAnswerHandler;
use App\Domain\Answer;
use App\Domain\Answer\AnswerId;
use App\Domain\Answer\AnswerRepository;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;

/**
 * DeleteAnswerHandlerSpec specs
 *
 * @package spec\App\Application\Answer
 */
class DeleteAnswerHandlerSpec extends ObjectBehavior
{
    private $answerId;

    function let(
        AnswerRepository $answers,
        EventDispatcher $dispatcher,
        Answer $answer
    ) {
        $this->answerId = new AnswerId();
        $answers->withId($this->answerId)->willReturn($answer);
        $answers->delete($answer)->willReturn($answer);

        $dispatcher->dispatchEventsFrom($answer)->willReturn([]);

        $this->beConstructedWith($answers, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteAnswerHandler::class);
    }

    function it_handles_remove_answer_command(
        EventDispatcher $dispatcher,
        Answer $answer
    ) {
        $command = new DeleteAnswerCommand($this->answerId);
        $this->handle($command)->shouldBe($answer);
        $dispatcher->dispatchEventsFrom($answer)->shouldHaveBeenCalled();
    }
}