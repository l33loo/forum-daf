<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Question;

use App\Domain\DomainException;
use App\Domain\Exception\EntityNotFound;
use App\Domain\Question;

/**
 * QuestionRepository
 *
 * @package App\Domain\Question
 */
interface QuestionRepository
{

    /**
     * Add a question to the repository
     *
     * @param Question $question The question to be added
     * @return Question The added question
     */
    public function add(Question $question): Question;

    /**
     * Get a question by its ID
     *
     * @param QuestionId $questionId The ID of the question to retrieve
     * @return Question The question with the specified ID
     * @throws DomainException|EntityNotFound When there are no questions with provided identifier
     */
    public function withId(QuestionId $questionId): Question;
}
