<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Events\Question;

use App\Domain\Events\Question\QuestionWasPost;
use App\Domain\Question\QuestionId;
use App\Domain\User\UserId;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * QuestionWasPostSpec specs
 *
 * @package spec\App\Domain\Events\Question
 */
class QuestionWasPostSpec extends ObjectBehavior
{

    private $questionId;
    private $userId;
    private $question;
    private $body;

    function let()
    {
        $this->questionId = new QuestionId();
        $this->userId = new UserId();
        $this->question = "Why?";
        $this->body = "Question body...";
        $this->beConstructedWith($this->questionId, $this->userId, $this->question, $this->body);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(QuestionWasPost::class);
    }

    function it_has_a_questionId()
    {
        $this->questionId()->shouldBe($this->questionId);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }

    function it_has_a_question()
    {
        $this->question()->shouldBe($this->question);
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
            'questionId' => $this->questionId,
            'userId' => $this->userId,
            'question' => $this->question,
        ]);
    }
}