<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\Comment;

use App\Domain\Event\Comment\CommentWasUnpublished;
use App\Domain\Comment\CommentId;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * CommentWasUnpublishedSpec specs
 *
 * @package spec\App\Domain\Event\Comment
 */
class CommentWasUnpublishedSpec extends ObjectBehavior
{

    private $commentId;

    function let()
    {
        $this->commentId = new CommentId();
        $this->beConstructedWith($this->commentId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CommentWasUnpublished::class);
    }

    function it_has_a_commentId()
    {
        $this->commentId()->shouldBe($this->commentId);
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
        ]);
    }
}