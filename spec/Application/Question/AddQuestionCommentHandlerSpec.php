<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Question;

use App\Application\Question\AddQuestionCommentCommand;
use App\Application\Question\AddQuestionCommentHandler;
use App\Domain\Question;
use App\Domain\Question\QuestionId;
use App\Domain\Question\QuestionRepository;
use App\Domain\Comment;
use App\Domain\Comment\CommentRepository;
use App\Domain\Post\PostId;
use App\Domain\User;
use App\Domain\User\UserId;
use App\Domain\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;

/**
 * AddQuestionCommentHandlerSpec specs
 *
 * @package spec\App\Application\Question
 */
class AddQuestionCommentHandlerSpec extends ObjectBehavior
{
    private $questionId;
    private $postId;
    private $body;
    private $authorId;

    function let(
        QuestionRepository $questions,
        UserRepository $users,
        EventDispatcher $dispatcher,
        Question $question,
        User $author
    ) {
        $this->questionId = new QuestionId();
        $this->postId = new PostId();
        $this->body = "hello";
        $this->authorId = new UserId();
        $questions->withId($this->questionId)->willReturn($question);
        $users->withId($this->authorId)->willReturn($author);
        $author->userId()->willReturn($this->authorId);
        $question->addComment(Argument::type(Comment::class))->willReturn($question);

        $dispatcher->dispatchEventsFrom($question)->willReturn([]);

        $this->beConstructedWith($questions, $users, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddQuestionCommentHandler::class);
    }

    function it_adds_question_comment(
        Question $question,
        EventDispatcher $dispatcher
    ) {
        $command = new AddQuestionCommentCommand($this->questionId, $this->postId, $this->body, $this->authorId);
        $this->handle($command)->shouldBe($question);
        $question->addComment(Argument::type(Comment::class))->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($question)->shouldHaveBeenCalled();
    }
}