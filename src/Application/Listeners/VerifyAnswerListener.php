<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Listeners;

use App\Application\Answer\VerifyAnswerCommand;
use App\Application\Answer\VerifyAnswerHandler;
use App\Domain\Event\Answer\AnswerWasChanged;
use App\Domain\Event\Question\AnswerWasGiven;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * VerifyAnswerListener
 *
 * @package App\Application\Listeners
 */
#[AsEventListener(event: AnswerWasGiven::class, method: 'onAnswerPostedOrChanged')]
#[AsEventListener(event: AnswerWasChanged::class, method: 'onAnswerPostedOrChanged')]
final readonly class VerifyAnswerListener
{


    public function __construct(private VerifyAnswerHandler $handler)
    {
    }

    public function onAnswerPostedOrChanged(AnswerWasGiven|AnswerWasChanged $event): void
    {
        $this->handler->handle(
            new VerifyAnswerCommand($event->answerId())
        );
    }
}
