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
 * QuestionWasPublished
 *
 * @package App\Domain\Event\Question
 */
final class QuestionWasPublished extends AbstractEvent implements Event, JsonSerializable
{


    public function __construct(
        private readonly QuestionId $questionId,
        private readonly DateTimeImmutable $publishedOn
    ) {
        parent::__construct();
    }

    /**
     * QuestionWasPublished questionId
     *
     * @return QuestionId
     */
    public function questionId(): QuestionId
    {
        return $this->questionId;
    }

    /**
     * QuestionWasPublished publishedOn
     *
     * @return DateTimeImmutable
     */
    public function publishedOn(): DateTimeImmutable
    {
        return $this->publishedOn;
    }

    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'questionId' => $this->questionId,
            'publishedOn' => $this->publishedOn,
        ];
    }
}
