<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\App\Application\Comment;

use App\Application\Comment\ChangeCommentCommand;
use App\Application\Comment\ChangeCommentHandler;
use App\Domain\Comment;
use App\Domain\Comment\CommentRepository;
use App\Domain\User;
use App\Domain\User\Email;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;

/**
 * ChangeCommentHandlerSpec specs
 *
 * @package spec\App\Application\Comment
 */
class ChangeCommentHandlerSpec extends ObjectBehavior
{
    private Comment $comment;

    function let(
        CommentRepository $comments,
        EventDispatcher $dispatcher
    ) {
        $user = new User(new Email('user@email.com'));
        $this->comment = new Comment($user, "Body...");
        $comments->withId($this->comment->commentId())->willReturn($this->comment);
        $dispatcher->dispatchEventsFrom(Argument::type(Comment::class))->willReturn([]);

        $this->beConstructedWith($comments, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ChangeCommentHandler::class);
    }

    function it_handles_change_comment_command(
        EventDispatcher $dispatcher
    ) {
        $command = new ChangeCommentCommand(
            $this->comment->commentId(),
            "Changed body..."
        );
        $this->handle($command)->shouldBe($this->comment);
        $dispatcher->dispatchEventsFrom($this->comment)->shouldHaveBeenCalled();
    }
}