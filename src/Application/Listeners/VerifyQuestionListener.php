<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Listeners;

use App\Application\Question\VerifyQuestionCommand;
use App\Application\Question\VerifyQuestionHandler;
use App\Domain\Event\Question\QuestionHasChanged;
use App\Domain\Event\Question\QuestionWasPosted;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * VerifyQuestionListener
 *
 * @package App\Application\Listeners
 */
#[AsEventListener(event: QuestionWasPosted::class, method: 'onQuestionPostedOrChanged')]
#[AsEventListener(event: QuestionHasChanged::class, method: 'onQuestionPostedOrChanged')]
final readonly class VerifyQuestionListener
{


    public function __construct(private VerifyQuestionHandler $handler)
    {
    }

    public function onQuestionPostedOrChanged(QuestionWasPosted|QuestionHasChanged $event): void
    {
        $this->handler->handle(
            new VerifyQuestionCommand($event->questionId())
        );
    }
}
