<?php

declare(strict_types=1);

namespace spec\App\Domain;

use App\Domain\Question;
use App\Domain\Tag;
use App\Domain\Event\Tag\TagWasCreated;
use App\Domain\User;
use App\Domain\User\Email;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventGenerator;

class TagSpec extends ObjectBehavior
{
    private $tag;
    private $question;
    private $user;

    function let(): void
    {
        $this->tag = 'Sometag';
        $this->user = new User(new Email('user@email.com'));
        $this->question = new Question($this->user, "Question?", "Body...");

        $this->beConstructedWith($this->tag);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(Tag::class);
    }

    function it_has_a_tag(): void
    {
        $this->tag()->shouldBe($this->tag);
    }

    function its_an_event_generator()
    {
        $this->shouldBeAnInstanceOf(EventGenerator::class);
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(TagWasCreated::class);
    }

    function it_can_be_added_a_question() {
        $this->releaseEvents();
        $this->questions()->shouldHaveCount(0);
        $this->addQuestion($this->question)->shouldBe($this->getWrappedObject());
        $this->questions()->shouldHaveCount(1);
        $this->questions()[0]->shouldBe($this->question);
    }

    function it_can_be_removed_a_question() {
        $this->releaseEvents();
        $this->addQuestion($this->question);
        $this->questions()->shouldHaveCount(1);
        $this->removeQuestion($this->question)->shouldBe($this->getWrappedObject());
        $this->questions()->shouldHaveCount(0);
    }
}