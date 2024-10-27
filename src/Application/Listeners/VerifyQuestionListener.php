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
use App\Domain\Event\Question\QuestionWasPosted;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * VerifyQuestionListener
 *
 * @package App\Application\Listeners
 */
#[AsEventListener(event: QuestionWasPosted::class, method: 'onQuestionPost')]
final readonly class VerifyQuestionListener
{


    public function __construct(private VerifyQuestionHandler $handler)
    {
    }


    public function onQuestionPost(QuestionWasPosted $event): void
    {
        $this->handler->handle(
            new VerifyQuestionCommand($event->questionId())
        );
    }
}
