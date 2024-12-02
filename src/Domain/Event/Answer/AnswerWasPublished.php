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
use DateTimeImmutable;
use JsonSerializable;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * AnswerWasPublished
 *
 * @package App\Domain\Event\Answer
 */
final class AnswerWasPublished extends AbstractEvent implements Event, JsonSerializable
{


    public function __construct(
        private readonly AnswerId $answerId,
        private readonly DateTimeImmutable $publishedOn
    ) {
        parent::__construct();
    }

    /**
     * AnswerWasPublished answerId
     *
     * @return AnswerId
     */
    public function answerId(): AnswerId
    {
        return $this->answerId;
    }

    /**
     * AnswerWasPublished publishedOn
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
            'answerId' => $this->answerId,
            'publishedOn' => $this->publishedOn,
        ];
    }
}
