<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Listeners;

use App\Application\Comment\UnpublishCommentCommand;
use App\Application\Comment\UnpublishCommentHandler;
use App\Domain\Event\Comment\CommentWasRejected;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * UnpublishCommentListener
 *
 * @package App\Application\Listeners
 */
#[AsEventListener(event: CommentWasRejected::class, method: 'onCommentWasRejected')]
final readonly class UnpublishCommentListener
{

    public function __construct(private UnpublishCommentHandler $handler)
    {
    }


    public function onCommentWasAccepted(CommentWasRejected $event): void
    {
        $this->handler->handle(new UnpublishCommentCommand($event->commentId()));
    }
}
