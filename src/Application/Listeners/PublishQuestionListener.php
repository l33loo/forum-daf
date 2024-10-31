<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Listeners;

use App\Application\Question\PublishQuestionCommand;
use App\Application\Question\PublishQuestionHandler;
use App\Domain\Event\Question\QuestionWasAccepted;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * PublishQuestionListener
 *
 * @package App\Application\Listeners
 */
#[AsEventListener(event: QuestionWasAccepted::class, method: 'onQuestionWasAccepted')]
final readonly class PublishQuestionListener
{

    public function __construct(private PublishQuestionHandler $handler)
    {
    }


    public function onQuestionWasAccepted(QuestionWasAccepted $event): void
    {
        $this->handler->handle(new PublishQuestionCommand($event->questionId()));
    }
}
