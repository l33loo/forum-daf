<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain;

use App\Domain\Event\Question\QuestionWasAccepted;
use App\Domain\Event\Question\QuestionWasPost;
use App\Domain\Post;
use App\Domain\Question;
use App\Domain\Question\QuestionId;
use App\Domain\User;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventGenerator;

/**
 * QuestionSpec specs
 *
 * @package spec\App\Domain
 */
class QuestionSpec extends ObjectBehavior
{

    private $question;
    private $body;

    function let(User $author)
    {
        $this->question = "Why?";
        $this->body = "Question body...";

        $author->userId()->willReturn(new User\UserId());

        $this->beConstructedWith($author, $this->question, $this->body);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Question::class);
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

    function it_has_a_question()
    {
        $this->question()->shouldBe($this->question);
    }

    function it_has_a_question_id()
    {
        $this->questionId()->shouldBeAnInstanceOf(QuestionId::class);
    }

    function its_an_event_generator()
    {
        $this->shouldBeAnInstanceOf(EventGenerator::class);
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(QuestionWasPost::class);
    }

    function it_can_be_accepted()
    {
        $this->releaseEvents();
        $this->isAccepted()->shouldBe(false);
        $this->accept()->shouldBe($this->getWrappedObject());
        $this->isAccepted()->shouldBe(true);
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(QuestionWasAccepted::class);
    }
}