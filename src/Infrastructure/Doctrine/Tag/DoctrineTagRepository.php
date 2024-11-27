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
    public function add(Tag $tag): Tag
    {
        $this->entityManager->persist($tag);
        return $tag;
    }

    /**
     * @inheritDoc
     */
    public function withId(TagId $tagId): Tag
    {
        $tag = $this->entityManager->find(Tag::class, $tagId);
        if ($tag instanceof Tag) {
            return $tag;
        }

        throw new EntityNotFound("Tag with id {$tagId} not found");
    }

    /**
     * @inheritDoc
     */
    public function withTagText(string $tag): Tag
    {
        $tag = $this->entityManager->find(Tag::class, $tag);
        if ($tag instanceof Tag) {
            return $tag;
        }

        throw new EntityNotFound("Tag with text {$tag} not found");
    }

    /**
     * @inheritDoc
     */
    public function remove(Tag $tag): Tag
    {
        $this->entityManager->remove($tag);
        $tag->recordThat(new TagWasDeleted($tag->tagId()));
        return $tag;
    }
}
