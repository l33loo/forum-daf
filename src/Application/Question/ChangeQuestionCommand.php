<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Question;

use App\Domain\Question\QuestionId;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;

#[AsResourceObject(type: "questions")]
final class ChangeQuestionCommand
{
    public function __construct(
        private QuestionId $questionId,
        private string $question,
        private string $body
    ) {}

    public function questionId(): QuestionId
    {
        return $this->questionId;
    }

    public function question(): string
    {
        return $this->question;
    }

    public function body(): string
    {
        return $this->body;
    }
}