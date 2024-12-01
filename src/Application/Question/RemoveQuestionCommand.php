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

/**
 * RemoveQuestionCommand
 *
 * @package App\Application\Question
 */
final readonly class RemoveQuestionCommand
{
    public function __construct(private QuestionId $questionId)
    {
    }

    /**
     * RemoveQuestionCommand questionId
     *
     * @return QuestionId
     */
    public function questionId(): QuestionId
    {
        return $this->questionId;
    }
}
