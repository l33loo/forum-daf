<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Listeners;

use App\Application\Answer\UnpublishAnswerCommand;
use App\Application\Answer\UnpublishAnswerHandler;
use App\Domain\Event\Answer\AnswerWasRejected;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * UnpublishAnswerListener
 *
 * @package App\Application\Listeners
 */
#[AsEventListener(event: AnswerWasRejected::class, method: 'onAnswerWasRejected')]
final readonly class UnpublishAnswerListener
{

    public function __construct(private UnpublishAnswerHandler $handler)
    {
    }


    public function onAnswerWasAccepted(AnswerWasRejected $event): void
    {
        $this->handler->handle(new UnpublishAnswerCommand($event->answerId()));
    }
}
