<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Answer;

use App\Domain\Exception\EntityNotFound;
use App\Domain\Answer;
use App\Domain\Answer\AnswerId;
use App\Domain\Answer\AnswerRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * DoctrineAnswerRepository
 *
 * @package App\Infrastructure\Doctrine\Answer
 */
final readonly class DoctrineAnswerRepository implements AnswerRepository
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @inheritDoc
     */
    public function add(Answer $answer): Answer
    {
        $this->entityManager->persist($answer);
        return $answer;
    }

    /**
     * @inheritDoc
     */
    public function withId(AnswerId $answerId): Answer
    {
        $answer = $this->entityManager->find(Answer::class, $answerId);
        if ($answer instanceof Answer) {
            return $answer;
        }

        throw new EntityNotFound("Answer with id {$answerId} not found");
    }

    /**
     * @inheritDoc
     */
    public function delete(Answer $answer): Answer
    {
        $this->entityManager->remove($answer);
        $this->entityManager->flush();
        return $answer;
    }
}
