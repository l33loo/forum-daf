<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Listeners;

use App\Application\Comment\VerifyCommentCommand;
use App\Application\Comment\VerifyCommentHandler;
use App\Domain\Event\Comment\CommentWasChanged;
use App\Domain\Event\Comment\CommentWasAdded;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * VerifyCommentListener
 *
 * @package App\Application\Listeners
 */
#[AsEventListener(event: CommentWasAdded::class, method: 'onCommentPostedOrChanged')]
#[AsEventListener(event: CommentWasChanged::class, method: 'onCommentPostedOrChanged')]
final readonly class VerifyCommentListener
{


    public function __construct(private VerifyCommentHandler $handler)
    {
    }

    public function onCommentPostedOrChanged(CommentWasAdded|CommentWasChanged $event): void
    {
        $this->handler->handle(
            new VerifyCommentCommand($event->commentId())
        );
    }
}
