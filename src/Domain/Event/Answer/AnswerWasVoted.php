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
use App\Domain\User\UserId;
use JsonSerializable;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * AnswerWasVoted
 *
 * @package App\Domain\Event\Answer
 */
final class AnswerWasVoted extends AbstractEvent implements Event, JsonSerializable
{


    public function __construct(
        private readonly AnswerId $answerId,
        private readonly UserId $userId,
        private readonly bool $intention
    ) {
        parent::__construct();
    }

    /**
     * AnswerWasVoted answerId
     *
     * @return AnswerId
     */
    public function answerId(): AnswerId
    {
        return $this->answerId;
    }

    /**
     * AnswerWasVoted userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * AnswerWasVoted intention
     *
     * @return bool
     */
    public function intention(): bool
    {
        return $this->intention;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'answerId' => $this->answerId
        ];
    }
}
