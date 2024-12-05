<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain;

use App\Domain\Answer;
use App\Domain\Comment;
use App\Domain\Comment\CommentId;
use App\Domain\Event\Answer\AnswerWasAccepted;
use App\Domain\Event\Answer\AnswerWasChanged;
use App\Domain\Event\Answer\AnswerWasPublished;
use App\Domain\Event\Answer\AnswerWasRejected;
use App\Domain\Event\Answer\AnswerWasUnpublished;
use App\Domain\Event\Answer\AnswerWasVoted;
use App\Domain\Event\Comment\CommentWasAdded;
use App\Domain\Post;
use App\Domain\Question;
use App\Domain\User;
use App\Domain\User\Email;
use App\Domain\User\UserId;
use App\Domain\Vote;
use Doctrine\Common\Collections\Collection;
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
    private $author;

    function let(Comment $comment, Question $question, Vote $vote, User $user)
    {
        $this->body = "Answer body...";
        $this->author = new User(new Email('user@mail.com'));
        $comment->commentId()->willReturn(new CommentId());
        $comment->author()->willReturn($this->author);
        $comment->body()->willReturn($this->body);
        $vote->user()->willReturn($user);
        $vote->intention()->willReturn(true);
        $user->userId()->willReturn(new UserId());

        $this->beConstructedWith($this->author, $this->body, $question);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Answer::class);
    }

    function its_a_post()
    {
        $this->shouldBeAnInstanceOf(Post::class);
    }

    function it_has_author()
    {
        $this->author()->shouldBe($this->author);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }

    function its_an_event_generator()
    {
        $this->shouldBeAnInstanceOf(EventGenerator::class);
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

    function it_can_be_unpublished()
    {
        $this->publish();
        $this->releaseEvents();
        $this->isPublished()->shouldBe(true);
        $this->unpublish()->shouldBe($this->getWrappedObject());
        $this->isPublished()->shouldBe(false);
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(AnswerWasUnpublished::class);
    }

    function it_can_be_changed()
    {
        $this->releaseEvents();
        $this->change('New body...')->shouldBe($this->getWrappedObject());
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(AnswerWasChanged::class);
    }

    function it_has_comments()
    {
        $this->comments()->shouldHaveType(Collection::class);
    }

    function it_can_be_added_a_comment(
        Comment $comment
    ) {
        $this->releaseEvents();
        $this->addComment($comment)->shouldBe($this->getWrappedObject());
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(CommentWasAdded::class);
    }

    function it_has_a_question()
    {
        $this->question()->shouldHaveType(Question::class);
    }

    function is_has_votes()
    {
       $this->votes()->shouldHaveType(Collection::class);
    }

    function it_can_be_added_a_vote(
        Vote $vote
    ) {
        $this->releaseEvents();
        $this->addVote($vote)->shouldBe($this->getWrappedObject());
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(AnswerWasVoted::class);
    }
}