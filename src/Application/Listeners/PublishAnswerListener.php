<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Listeners;

use App\Application\Answer\PublishAnswerCommand;
use App\Application\Answer\PublishAnswerHandler;
use App\Domain\Event\Answer\AnswerWasAccepted;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * PublishAnswerListener
 *
 * @package App\Application\Listeners
 */
#[AsEventListener(event: AnswerWasAccepted::class, method: 'onAnswerWasAccepted')]
final readonly class PublishAnswerListener
{

    public function __construct(private PublishAnswerHandler $handler)
    {
    }


    public function onAnswerWasAccepted(AnswerWasAccepted $event): void
    {
        $this->handler->handle(new PublishAnswerCommand($event->answerId()));
    }
}
