<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Answer;

use App\Domain\Answer;
use App\Domain\Answer\AnswerRepository;
use Slick\Event\EventDispatcher;

/**
 * UnpublishAnswerHandler
 *
 * @package App\Application\Answer
 */
final readonly class UnpublishAnswerHandler
{


    public function __construct(
        private AnswerRepository $answers,
        private EventDispatcher $eventDispatcher
    ) {
    }

    public function handle(UnpublishAnswerCommand $command): Answer
    {
        $answer = $this->answers->withId($command->answerId());
        $this->eventDispatcher->dispatchEventsFrom($answer->unpublish());
        return $answer;
    }
}
