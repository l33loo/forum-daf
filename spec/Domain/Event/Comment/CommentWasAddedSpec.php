<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\Comment;

use App\Domain\Event\Comment\CommentWasAdded;
use App\Domain\Comment\CommentId;
use App\Domain\User\UserId;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * CommentWasAddedSpec specs
 *
 * @package spec\App\Domain\Events\Comment
 */
class CommentWasAddedSpec extends ObjectBehavior
{

    private $commentId;
    private $userId;
    private $body;

    function let()
    {
        $this->commentId = new CommentId();
        $this->userId = new UserId();
        $this->body = "Comment body...";
        $this->beConstructedWith($this->commentId, $this->userId, $this->body);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CommentWasAdded::class);
    }

    function it_has_a_commentId()
    {
        $this->commentId()->shouldBe($this->commentId);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
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
            'commentId' => $this->commentId,
            'userId' => $this->userId,
            'body' => $this->body,
        ]);
    }
}