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
 * QuestionWasPost
 *
 * @package App\Domain\Events\Question
 */
final class QuestionWasPost extends AbstractEvent implements Event, JsonSerializable
{


    /**
     * Creates a QuestionWasPost
     *
     * @param QuestionId $questionId The ID of the question.
     * @param UserId $userId The ID of the user who posted the question.
     * @param string $question The question text.
     * @param string $body The body text of the question.
     */
    public function __construct(
        private readonly QuestionId $questionId,
        private readonly UserId $userId,
        private readonly string $question,
        private readonly string $body
    ) {
        parent::__construct();
    }

    /**
     * QuestionWasPost questionId
     *
     * @return QuestionId
     */
    public function questionId(): QuestionId
    {
        return $this->questionId;
    }

    /**
     * QuestionWasPost userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * QuestionWasPost question
     *
     * @return string
     */
    public function question(): string
    {
        return $this->question;
    }

    /**
     * QuestionWasPost body
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
            'questionId' => $this->questionId,
            'userId' => $this->userId,
            'question' => $this->question,
        ];
    }
}
