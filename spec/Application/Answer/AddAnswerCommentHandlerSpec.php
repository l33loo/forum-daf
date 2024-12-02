<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Answer;

use App\Application\Answer\AddAnswerCommentCommand;
use App\Application\Answer\AddAnswerCommentHandler;
use App\Domain\Exception\EntityNotFound;
use App\Domain\Answer;
use App\Domain\Answer\AnswerId;
use App\Domain\Answer\AnswerRepository;
use App\Domain\Comment;
use App\Domain\Comment\CommentRepository;
use App\Domain\User;
use App\Domain\User\UserId;
use App\Domain\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;

/**
 * AddAnswerCommentHandlerSpec specs
 *
 * @package spec\App\Application\Answer
 */
class AddAnswerCommentHandlerSpec extends ObjectBehavior
{
    private $answerId;
    private $body;
    private $authorId;

    function let(
        AnswerRepository $answers,
        UserRepository $users,
        EventDispatcher $dispatcher,
        Answer $answer,
        User $author
    ) {
        $this->answerId = new AnswerId();
        $this->body = "hello";
        $this->authorId = new UserId();
        $answers->withId($this->answerId)->willReturn($answer);
        $users->withId($this->authorId)->willReturn($author);
        $author->userId()->willReturn($this->authorId);
        $answer->addComment(Argument::type(Comment::class))->willReturn($answer);

        $dispatcher->dispatchEventsFrom($answer)->willReturn([]);

        $this->beConstructedWith($answers, $users, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddAnswerCommentHandler::class);
    }

    function it_adds_answer_comment(
        Answer $answer,
        EventDispatcher $dispatcher
    ) {
        $command = new AddAnswerCommentCommand($this->answerId, $this->body, $this->authorId);
        $this->handle($command)->shouldBe($answer);
        $answer->addComment(Argument::type(Comment::class))->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($answer)->shouldHaveBeenCalled();
    }
}