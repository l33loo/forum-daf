<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Comment;

use App\Application\Comment\DeleteCommentCommand;
use App\Application\Comment\DeleteCommentHandler;
use App\Domain\Comment;
use App\Domain\Comment\CommentId;
use App\Domain\Comment\CommentRepository;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;

/**
 * DeleteCommentHandlerSpec specs
 *
 * @package spec\App\Application\Comment
 */
class DeleteCommentHandlerSpec extends ObjectBehavior
{
    private $commentId;

    function let(
        CommentRepository $comments,
        EventDispatcher $dispatcher,
        Comment $comment
    ) {
        $this->commentId = new CommentId();
        $comments->withId($this->commentId)->willReturn($comment);
        $comments->delete($comment)->willReturn($comment);

        $dispatcher->dispatchEventsFrom($comment)->willReturn([]);

        $this->beConstructedWith($comments, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteCommentHandler::class);
    }

    function it_handles_remove_comment_command(
        EventDispatcher $dispatcher,
        Comment $comment
    ) {
        $command = new DeleteCommentCommand($this->commentId);
        $this->handle($command)->shouldBe($comment);
        $dispatcher->dispatchEventsFrom($comment)->shouldHaveBeenCalled();
    }
}