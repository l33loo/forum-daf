<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Vote;

use App\Domain\Answer;
use App\Domain\Answer\AnswerId;
use App\Domain\Exception\EntityNotFound;
use App\Domain\User;
use App\Domain\User\UserId;
use App\Domain\Vote;
use App\Domain\Vote\VoteId;
use App\Domain\Vote\VoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

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
    public function withAnswerIdAndUserId(AnswerId $answerId, UserId $userId): Vote
    {
        $qb1 = new QueryBuilder($this->entityManager);
        $qb1->addSelect('a')
            ->from(Answer::class, 'a')
            ->where('a.answerId = ?1')
            ->setParameter(1, $answerId);

        $answer = $qb1->getQuery()->getOneOrNullResult();

        $qb2 = new QueryBuilder($this->entityManager);
        $qb2->addSelect('u')
            ->from(User::class, 'u')
            ->where('u.userId = ?1')
            ->setParameter(1, $userId);

        $user = $qb2->getQuery()->getOneOrNullResult();


        $qb = new QueryBuilder($this->entityManager);
        $qb->addSelect('v')
            ->from(Vote::class, 'v')
            ->where('v.answer = ?1')
            ->andWhere('v.user = ?2')
            ->setParameter(1, $answer)
            ->setParameter(2, $user);

        $vote = $qb->getQuery()->getOneOrNullResult();

        if ($vote instanceof Vote) {
            return $vote;
        }

        throw new EntityNotFound("Vote with AnswerId {$answerId} and UserId {$userId} not found");
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
