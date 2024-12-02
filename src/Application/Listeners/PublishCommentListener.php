<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Listeners;

use App\Application\Comment\PublishCommentCommand;
use App\Application\Comment\PublishCommentHandler;
use App\Domain\Event\Comment\CommentWasAccepted;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * PublishCommentListener
 *
 * @package App\Application\Listeners
 */
#[AsEventListener(event: CommentWasAccepted::class, method: 'onCommentWasAccepted')]
final readonly class PublishCommentListener
{

    public function __construct(private PublishCommentHandler $handler)
    {
    }


    public function onCommentWasAccepted(CommentWasAccepted $event): void
    {
        $this->handler->handle(new PublishCommentCommand($event->commentId()));
    }
}
