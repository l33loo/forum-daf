<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Question;

use App\Domain\User\UserId;

/**
 * PostQuestionCommand
 *
 * @package App\Application\Question
 */
final readonly class PostQuestionCommand
{


    public function __construct(
        private UserId $userId,
        private string $question,
        private string $body,
    ) {
    }

    /**
     * PostQuestionCommand userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * PostQuestionCommand question
     *
     * @return string
     */
    public function question(): string
    {
        return $this->question;
    }

    /**
     * PostQuestionCommand body
     *
     * @return string
     */
    public function body(): string
    {
        return $this->body;
    }
}
