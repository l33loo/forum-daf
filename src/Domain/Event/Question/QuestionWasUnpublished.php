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
use DateTimeImmutable;
use JsonSerializable;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * QuestionWasUnpublished
 *
 * @package App\Domain\Event\Question
 */
final class QuestionWasUnpublished extends AbstractEvent implements Event, JsonSerializable
{


    public function __construct(
        private readonly QuestionId $questionId
    ) {
        parent::__construct();
    }

    /**
     * QuestionWasUnpublished questionId
     *
     * @return QuestionId
     */
    public function questionId(): QuestionId
    {
        return $this->questionId;
    }

    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'questionId' => $this->questionId,
        ];
    }
}
