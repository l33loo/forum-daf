<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain;

use App\Domain\Answer;
use App\Domain\Event\Answer\AnswerWasAccepted;
use App\Domain\Event\Answer\AnswerWasGiven;
use App\Domain\Event\Answer\AnswerWasPublished;
use App\Domain\Event\Answer\AnswerWasRejected;
use App\Domain\Post;
use App\Domain\User;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventGenerator;

/**
 * AnswerSpec specs
 *
 * @package spec\App\Domain
 */
class AnswerSpec extends ObjectBehavior
{
    private $body;

    function let(User $author)
    {
        $this->body = "Answer body...";

        $author->userId()->willReturn(new User\UserId());

        $this->beConstructedWith($author, $this->body);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Answer::class);
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
        $events[0]->shouldBeAnInstanceOf(AnswerWasGiven::class);
    }

    function it_can_be_accepted()
    {
        $this->releaseEvents();
        $this->isAccepted()->shouldBe(false);
        $this->accept()->shouldBe($this->getWrappedObject());
        $this->isAccepted()->shouldBe(true);
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(AnswerWasAccepted::class);
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
        $events[0]->shouldBeAnInstanceOf(AnswerWasRejected::class);
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
        $events[0]->shouldBeAnInstanceOf(AnswerWasPublished::class);
    }

//    function it_can_be_unpublished()
//    {
//        $this->publish();
//        $this->releaseEvents();
//        $this->isPublished()->shouldBe(true);
//        $this->unpublish()->shouldBe($this->getWrappedObject());
//        $this->isPublished()->shouldBe(false);
//        $events = $this->releaseEvents();
//        $events->shouldHaveCount(1);
//        $events[0]->shouldBeAnInstanceOf(AnswerWasUnpublished::class);
//    }
//
//    function it_can_be_changed() {
//        $this->releaseEvents();
//        $this->change('New body...')->shouldBe($this->getWrappedObject());
//        $events = $this->releaseEvents();
//        $events->shouldHaveCount(1);
//    }
}