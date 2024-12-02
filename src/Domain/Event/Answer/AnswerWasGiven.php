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
 * AnswerWasGiven
 *
 * @package App\Domain\Events\Answer
 */
final class AnswerWasGiven extends AbstractEvent implements Event, JsonSerializable
{


    /**
     * Creates a AnswerWasGiven
     *
     * @param AnswerId $answerId The ID of the answer.
     * @param UserId $userId The ID of the user who posted the answer.
     * @param string $body The body text of the answer.
     */
    public function __construct(
        private readonly AnswerId $answerId,
        private readonly UserId $userId,
        private readonly string $body
    ) {
        parent::__construct();
    }

    /**
     * AnswerWasGiven answerId
     *
     * @return AnswerId
     */
    public function answerId(): AnswerId
    {
        return $this->answerId;
    }

    /**
     * AnswerWasGiven userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * AnswerWasGiven answer
     *
     * @return string
     */
    public function answer(): string
    {
        return $this->answer;
    }

    /**
     * AnswerWasGiven body
     *
     * @return string
     */
    public function body(): string
    {
        return $this->body;
    }

    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'answerId' => $this->answerId,
            'userId' => $this->userId,
            'body' => $this->body,
        ];
    }
}
