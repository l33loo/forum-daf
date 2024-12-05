<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Vote;

use App\Domain\DomainException;
use App\Domain\Exception\EntityNotFound;
use App\Domain\Vote;

/**
 * VoteRepository
 *
 * @package App\Domain\Vote
 */
interface VoteRepository
{

    /**
     * Add a vote to the repository
     *
     * @param Vote $vote The vote to be added
     * @return Vote The added vote
     */
    public function add(Vote $vote): Vote;

    /**
     * Get a vote by its ID
     *
     * @param VoteId $voteId The ID of the vote to retrieve
     * @return Vote The vote with the specified ID
     * @throws DomainException|EntityNotFound When there are no votes with provided identifier
     */
    public function withId(VoteId $voteId): Vote;

    /**
     * Delete a vote from the repository
     *
     * @param Vote $vote The vote to be deleted
     * @return Vote The deleted vote
     */
    public function delete(Vote $vote): Vote;
}
