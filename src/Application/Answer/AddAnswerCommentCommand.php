<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Answer;

use App\Domain\Answer\AnswerId;
use App\Domain\User\UserId;

/**
 * AddAnswerCommentCommand
 *
 * @package App\Application\Answer
 */
final class AddAnswerCommentCommand
{
    public function __construct(
        private AnswerId $answerId,
        private string $body,
        private UserId $authorId
    ) {
    }

    public function answerId(): AnswerId
    {
        return $this->answerId;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function authorId(): UserId
    {
        return $this->authorId;
    }
}