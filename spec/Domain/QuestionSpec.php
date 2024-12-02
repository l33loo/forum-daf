<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain;

use App\Domain\Comment;
use App\Domain\Event\Comment\CommentWasAdded;
use App\Domain\Event\Question\QuestionHasChanged;
use App\Domain\Event\Question\QuestionWasAccepted;
use App\Domain\Event\Question\QuestionWasPosted;
use App\Domain\Event\Question\QuestionWasPublished;
use App\Domain\Event\Question\QuestionWasRejected;
use App\Domain\Event\Question\QuestionWasUnpublished;
use App\Domain\Event\Question\TagWasAdded;
use App\Domain\Event\Question\TagWasRemoved;
use App\Domain\Post;
use App\Domain\Question;
use App\Domain\Question\QuestionId;
use App\Domain\Tag;
use App\Domain\User;
use Doctrine\Common\Collections\Collection;
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
    private $tag;

    function let(User $author, Comment $comment)
    {
        $this->question = "Why?";
        $this->body = "Question body...";
        $this->tag = new Tag("hello");
        $comment->commentId()->willReturn(new Comment\CommentId());
        $comment->author()->willReturn($author);
        $comment->body()->willReturn($this->body);

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
        $events[0]->shouldBeAnInstanceOf(QuestionWasPosted::class);
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
        $events[0]->shouldBeAnInstanceOf(QuestionWasRejected::class);
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
        $events[0]->shouldBeAnInstanceOf(QuestionWasPublished::class);
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
        $events[0]->shouldBeAnInstanceOf(QuestionWasUnpublished::class);
    }

    function it_can_be_added_a_tag() {
        $this->releaseEvents();
        $this->tags()->shouldHaveCount(0);
        $this->addTag($this->tag)->shouldBe($this->getWrappedObject());
        $this->tags()->shouldHaveCount(1);
        $this->tags()[0]->shouldBe($this->tag);
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(TagWasAdded::class);
    }

    function it_can_be_removed_a_tag() {
        $this->addTag($this->tag);
        $this->releaseEvents();
        $this->tags()->shouldHaveCount(1);
        $this->removeTag($this->tag)->shouldBe($this->getWrappedObject());
        $this->tags()->shouldHaveCount(0);
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(TagWasRemoved::class);
    }

    function it_can_be_changed() {
        $this->releaseEvents();
        $this->change('New question?', 'New body...')->shouldBe($this->getWrappedObject());
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(QuestionHasChanged::class);
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
}