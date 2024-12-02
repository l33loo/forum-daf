<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\Comment;

use App\Domain\Event\Comment\CommentWasRejected;
use App\Domain\Comment\CommentId;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * CommentWasRejectedSpec specs
 *
 * @package spec\App\Domain\Event\Comment
 */
class CommentWasRejectedSpec extends ObjectBehavior
{

    private $commentId;
    private $rejectReason;

    function let()
    {
        $this->commentId = new CommentId();
        $this->rejectReason = 'Invalid subject';
        $this->beConstructedWith($this->commentId, $this->rejectReason);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CommentWasRejected::class);
    }

    function it_has_a_commentId()
    {
        $this->commentId()->shouldBe($this->commentId);
    }

    function it_has_a_rejectReason()
    {
        $this->rejectReason()->shouldBe($this->rejectReason);
    }


    function its_an_event()
    {
        $this->shouldBeAnInstanceOf(Event::class);
        $this->shouldHaveType(AbstractEvent::class);
        $this->occurredOn()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
    }

    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(\JsonSerializable::class);
        $this->jsonSerialize()->shouldBeLike([
            'commentId' => $this->commentId,
            'rejectReason' => $this->rejectReason,
        ]);
    }
}