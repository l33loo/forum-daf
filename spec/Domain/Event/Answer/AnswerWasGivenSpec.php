<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\Answer;

use App\Domain\Event\Answer\AnswerWasGiven;
use App\Domain\Answer\AnswerId;
use App\Domain\Question\QuestionId;
use App\Domain\User\UserId;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * AnswerWasGivenSpec specs
 *
 * @package spec\App\Domain\Events\Answer
 */
class AnswerWasGivenSpec extends ObjectBehavior
{

    private $answerId;
    private $userId;
    private $questionId;
    private $body;

    function let()
    {
        $this->answerId = new AnswerId();
        $this->userId = new UserId();
        $this->questionId = new QuestionId();
        $this->body = "Answer body...";
        $this->beConstructedWith($this->answerId, $this->userId, $this->questionId, $this->body);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AnswerWasGiven::class);
    }

    function it_has_a_answerId()
    {
        $this->answerId()->shouldBe($this->answerId);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }

    function it_has_a_questionId()
    {
        $this->questionId()->shouldBe($this->questionId);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }

    function its_an_event()
    {
        $this->shouldBeAnInstanceOf(Event::class);
        $this->shouldHaveType(AbstractEvent::class);
        $this->occurredOn()->shouldBeAnInstanceOf(DateTimeImmutable::class);
    }

    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(\JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            'answerId' => $this->answerId,
            'userId' => $this->userId,
            'body' => $this->body,
        ]);
    }
}