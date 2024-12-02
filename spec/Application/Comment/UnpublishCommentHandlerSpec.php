<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Comment;

use App\Application\Comment\UnpublishCommentCommand;
use App\Application\Comment\UnpublishCommentHandler;
use App\Domain\Comment;
use App\Domain\Comment\CommentId;
use App\Domain\Comment\CommentRepository;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;

/**
 * UnpublishCommentHandlerSpec specs
 *
 * @package spec\App\Application\Comment
 */
class UnpublishCommentHandlerSpec extends ObjectBehavior
{
    private $commentId;

    function let(
        CommentRepository $comments,
        EventDispatcher $dispatcher,
        Comment $comment
    ) {
        $this->commentId = new CommentId();
        $comments->withId($this->commentId)->willReturn($comment);
        $comment->unpublish()->willReturn($comment);

        $dispatcher->dispatchEventsFrom($comment)->willReturn([]);

        $this->beConstructedWith($comments, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UnpublishCommentHandler::class);
    }

    function it_handles_publish_comment_command(
        EventDispatcher $dispatcher,
        Comment $comment
    ) {
        $command = new UnpublishCommentCommand($this->commentId);
        $this->handle($command)->shouldBe($comment);
        $comment->unpublish()->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($comment)->shouldHaveBeenCalled();
    }
}