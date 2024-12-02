<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain;

use App\Domain\Comment;
use App\Domain\Event\Comment\CommentWasAccepted;
use App\Domain\Event\Comment\CommentWasChanged;
use App\Domain\Event\Comment\CommentWasGiven;
use App\Domain\Event\Comment\CommentWasPublished;
use App\Domain\Event\Comment\CommentWasRejected;
use App\Domain\Event\Comment\CommentWasUnpublished;
use App\Domain\Post;
use App\Domain\User;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventGenerator;

/**
 * CommentSpec specs
 *
 * @package spec\App\Domain
 */
class CommentSpec extends ObjectBehavior
{
    private $body;

    function let(User $author)
    {
        $this->body = "Comment body...";

        $author->userId()->willReturn(new User\UserId());

        $this->beConstructedWith($author, $this->body);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Comment::class);
    }

    function its_a_post()
    {
        $this->shouldBeAnInstanceOf(Post::class);
    }

    function it_has_author(User $author)
    {
        $this->author()->shouldBe($author);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }

    function its_an_event_generator()
    {
        $this->shouldBeAnInstanceOf(EventGenerator::class);
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(CommentWasAdded::class);
    }

    function it_can_be_accepted()
    {
        $this->releaseEvents();
        $this->isAccepted()->shouldBe(false);
        $this->accept()->shouldBe($this->getWrappedObject());
        $this->isAccepted()->shouldBe(true);
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(CommentWasAccepted::class);
    }

    function it_can_be_rejected()
    {
        $this->accept();
        $this->releaseEvents();
        $this->isAccepted()->shouldBe(true);

        $reason = "Offensive content";
        $this->reject($reason)->shouldBe($this->getWrappedObject());
        $this->isAccepted()->shouldBe(false);
        $this->rejectReason()->shouldBe($reason);

        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(CommentWasRejected::class);
    }

    function it_can_be_published()
    {
        $this->releaseEvents();
        $this->isPublished()->shouldBe(false);
        $this->publishedOn()->shouldBe(null);
        $this->publish()->shouldBe($this->getWrappedObject());
        $this->isPublished()->shouldBe(true);
        $this->publishedOn()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(CommentWasPublished::class);
    }

    function it_can_be_unpublished()
    {
        $this->publish();
        $this->releaseEvents();
        $this->isPublished()->shouldBe(true);
        $this->unpublish()->shouldBe($this->getWrappedObject());
        $this->isPublished()->shouldBe(false);
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(CommentWasUnpublished::class);
    }

    function it_can_be_changed() {
        $this->releaseEvents();
        $this->change('New body...')->shouldBe($this->getWrappedObject());
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(CommentWasChanged::class);
    }
}