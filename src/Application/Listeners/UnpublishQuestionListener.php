<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Listeners;

use App\Application\Question\UnpublishQuestionCommand;
use App\Application\Question\UnpublishQuestionHandler;
use App\Domain\Event\Question\QuestionWasRejected;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * UnpublishQuestionListener
 *
 * @package App\Application\Listeners
 */
#[AsEventListener(event: QuestionWasRejected::class, method: 'onQuestionWasRejected')]
final readonly class UnpublishQuestionListener
{

    public function __construct(private UnpublishQuestionHandler $handler)
    {
    }


    public function onQuestionWasAccepted(QuestionWasRejected $event): void
    {
        $this->handler->handle(new UnpublishQuestionCommand($event->questionId()));
    }
}
