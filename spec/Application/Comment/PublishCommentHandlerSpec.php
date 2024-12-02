<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Comment;

use App\Application\Comment\PublishCommentCommand;
use App\Application\Comment\PublishCommentHandler;
use App\Domain\Comment;
use App\Domain\Comment\CommentId;
use App\Domain\Comment\CommentRepository;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;

/**
 * PublishCommentHandlerSpec specs
 *
 * @package spec\App\Application\Comment
 */
class PublishCommentHandlerSpec extends ObjectBehavior
{
    private $commentId;

    function let(
        CommentRepository $comments,
        EventDispatcher $dispatcher,
        Comment $comment
    ) {
        $this->commentId = new CommentId();
        $comments->withId($this->commentId)->willReturn($comment);
        $comment->publish()->willReturn($comment);

        $dispatcher->dispatchEventsFrom($comment)->willReturn([]);

        $this->beConstructedWith($comments, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PublishCommentHandler::class);
    }

    function it_handles_publish_comment_command(
        EventDispatcher $dispatcher,
        Comment $comment
    ) {
        $command = new PublishCommentCommand($this->commentId);
        $this->handle($command)->shouldBe($comment);
        $comment->publish()->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($comment)->shouldHaveBeenCalled();
    }
}