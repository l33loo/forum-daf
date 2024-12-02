<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Answer;

use App\Domain\DomainException;
use App\Domain\Exception\EntityNotFound;
use App\Domain\Answer;

/**
 * AnswerRepository
 *
 * @package App\Domain\Answer
 */
interface AnswerRepository
{

    /**
     * Add a answer to the repository
     *
     * @param Answer $answer The answer to be added
     * @return Answer The added answer
     */
    public function add(Answer $answer): Answer;

    /**
     * Get a answer by its ID
     *
     * @param AnswerId $answerId The ID of the answer to retrieve
     * @return Answer The answer with the specified ID
     * @throws DomainException|EntityNotFound When there are no answers with provided identifier
     */
    public function withId(AnswerId $answerId): Answer;

    /**
     * Delete a answer from the repository
     *
     * @param Answer $answer The answer to be deleted
     * @return Answer The deleted answer
     */
    public function delete(Answer $answer): Answer;
}
