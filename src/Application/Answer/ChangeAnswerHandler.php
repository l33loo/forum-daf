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
 * ChangeAnswerHandler
 *
 * @package App\Application\Answer
 */
final readonly class ChangeAnswerHandler
{
    public function __construct(
        private AnswerRepository $answers,
        private EventDispatcher $dispatcher
    ) {
    }

    public function handle(ChangeAnswerCommand $command): Answer
    {
        $answer = $this->answers->withId($command->answerId());
        $this->dispatcher->dispatchEventsFrom(
            $answer->change($command->body())
        );

        return $answer;
    }
}