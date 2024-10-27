<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Event\Question;

use App\Domain\Question\QuestionId;
use App\Domain\User\UserId;
use JsonSerializable;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * QuestionWasRejected
 *
 * @package App\Domain\Event\Question
 */
final class QuestionWasRejected extends AbstractEvent implements Event, JsonSerializable
{


    /**
     * Creates a QuestionWasRejected
     *
     * @param QuestionId $questionId
     */
    public function __construct(
        private readonly QuestionId $questionId,
        private readonly string $rejectReason,
    ) {
        parent::__construct();
    }

    /**
     * QuestionWasRejected QuestionId
     *
     * @return QuestionId
     */
    public function questionId(): QuestionId
    {
        return $this->questionId;
    }

    /**
     * QuestionWasRejected rejectReason
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
            'questionId' => $this->questionId,
        ];
    }
}
