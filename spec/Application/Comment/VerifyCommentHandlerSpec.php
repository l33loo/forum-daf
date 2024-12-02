<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Comment;

use App\Application\Comment\VerifyCommentCommand;
use App\Application\Comment\VerifyCommentHandler;
use App\Domain\Comment;
use App\Domain\Comment\CommentId;
use App\Domain\Comment\CommentRepository;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;

/**
 * VerifyCommentHandlerSpec specs
 *
 * @package spec\App\Application\Comment
 */
class VerifyCommentHandlerSpec extends ObjectBehavior
{

    private $commentId;
    private $reason;

    function let(
        CommentRepository $comments,
        Comment\Specification\AcceptableCommentSpecification $acceptable,
        EventDispatcher $dispatcher,
        Comment $comment
    ) {
        $this->commentId = new CommentId();
        $this->reason = 'some reason';
        $comments->withId($this->commentId)->willReturn($comment);

        $acceptable->isSatisfiedBy($comment)->willReturn(true);
        $comment->accept()->willReturn($comment);
        $comment->reject($this->reason)->willReturn($comment);

        $dispatcher->dispatchEventsFrom($comment)->willReturn([]);

        $this->beConstructedWith($comments, $acceptable, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(VerifyCommentHandler::class);
    }

    function it_handles_verify_comment_command(Comment $comment, EventDispatcher $dispatcher)
    {
        $command = new VerifyCommentCommand($this->commentId);

        $this->handle($command)->shouldBe($comment);

        $comment->accept()->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($comment)->shouldHaveBeenCalled();
    }

    function it_rejects_comment_when_acceptable_spec_fails(
        Comment\Specification\AcceptableCommentSpecification $acceptable,
        Comment $comment
    ) {
        $acceptable->isSatisfiedBy($comment)->willReturn(false);
        $acceptable->reason()->willReturn($this->reason);

        $command = new VerifyCommentCommand($this->commentId);

        $this->handle($command);

        $comment->reject($this->reason)->shouldHaveBeenCalled();
    }
}