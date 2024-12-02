<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\Comment;

use App\Domain\Event\Comment\CommentWasPublished;
use App\Domain\Comment\CommentId;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * CommentWasPublishedSpec specs
 *
 * @package spec\App\Domain\Event\Comment
 */
class CommentWasPublishedSpec extends ObjectBehavior
{

    private $commentId;
    private $publishedOn;

    function let()
    {
        $this->commentId = new CommentId();
        $this->publishedOn = new DateTimeImmutable();
        $this->beConstructedWith($this->commentId, $this->publishedOn);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CommentWasPublished::class);
    }

    function it_has_a_commentId()
    {
        $this->commentId()->shouldBe($this->commentId);
    }

    function it_has_a_publishedOn()
    {
        $this->publishedOn()->shouldBe($this->publishedOn);
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
            'publishedOn' => $this->publishedOn,
        ]);
    }
}