<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Question;

use App\Domain\Exception\EntityNotFound;
use App\Domain\Question;
use App\Domain\Question\QuestionId;
use App\Domain\Question\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * DoctrineQuestionRepository
 *
 * @package App\Infrastructure\Doctrine\Question
 */
final readonly class DoctrineQuestionRepository implements QuestionRepository
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @inheritDoc
     */
    public function add(Question $question): Question
    {
        $this->entityManager->persist($question);
        return $question;
    }

    /**
     * @inheritDoc
     */
    public function withId(QuestionId $questionId): Question
    {
        $question = $this->entityManager->find(Question::class, $questionId);
        if ($question instanceof Question) {
            return $question;
        }

        throw new EntityNotFound("Question with id {$questionId} not found");
    }
}
