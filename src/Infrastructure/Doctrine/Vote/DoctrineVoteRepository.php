<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Vote;

use App\Domain\Exception\EntityNotFound;
use App\Domain\Vote;
use App\Domain\Vote\VoteId;
use App\Domain\Vote\VoteRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * DoctrineVoteRepository
 *
 * @package App\Infrastructure\Doctrine\Vote
 */
final readonly class DoctrineVoteRepository implements VoteRepository
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @inheritDoc
     */
    public function add(Vote $vote): Vote
    {
        $this->entityManager->persist($vote);
        return $vote;
    }

    /**
     * @inheritDoc
     */
    public function withId(VoteId $voteId): Vote
    {
        $vote = $this->entityManager->find(Vote::class, $voteId);
        if ($vote instanceof Vote) {
            return $vote;
        }

        throw new EntityNotFound("Vote with id {$voteId} not found");
    }

    /**
     * @inheritDoc
     */
    public function delete(Vote $vote): Vote
    {
        $this->entityManager->remove($vote);
        $this->entityManager->flush();
        return $vote;
    }
}
