<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Event\Answer;

use App\Domain\Answer\AnswerId;
use JsonSerializable;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * AnswerWasRejected
 *
 * @package App\Domain\Event\Answer
 */
final class AnswerWasRejected extends AbstractEvent implements Event, JsonSerializable
{


    /**
     * Creates a AnswerWasRejected
     *
     * @param AnswerId $answerId
     */
    public function __construct(
        private readonly AnswerId $answerId,
        private readonly string $rejectReason,
    ) {
        parent::__construct();
    }

    /**
     * AnswerWasRejected AnswerId
     *
     * @return AnswerId
     */
    public function answerId(): AnswerId
    {
        return $this->answerId;
    }

    /**
     * AnswerWasRejected rejectReason
     *
     * @return string
     */
    public function rejectReason(): string
    {
        return $this->rejectReason;
    }

    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'rejectReason' => $this->rejectReason,
            'answerId' => $this->answerId,
        ];
    }
}
