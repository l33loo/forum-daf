<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Tag;

use App\Domain\Exception\EntityNotFound;
use App\Domain\Tag;
use App\Domain\Tag\TagId;
use App\Domain\Tag\TagRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * DoctrineTagRepository
 *
 * @package App\Infrastructure\Doctrine\Tag
 */
final readonly class DoctrineTagRepository implements TagRepository
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @inheritDoc
     */
    public function add(Tag $question): Tag
    {
        $this->entityManager->persist($question);
        return $question;
    }

    /**
     * @inheritDoc
     */
    public function withId(TagId $questionId): Tag
    {
        $question = $this->entityManager->find(Tag::class, $questionId);
        if ($question instanceof Tag) {
            return $question;
        }

        throw new EntityNotFound("Tag with id {$questionId} not found");
    }
}
