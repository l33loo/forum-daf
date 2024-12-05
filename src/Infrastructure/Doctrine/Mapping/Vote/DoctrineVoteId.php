<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Mapping\Vote;

use App\Domain\Vote\VoteId;
use App\Infrastructure\Doctrine\Mapping\User\DoctrineUserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

/**
 * DoctrineVoteId
 *
 * @package App\Infrastructure\Doctrine\Mapping\Vote
 */
final class DoctrineVoteId extends GuidType
{
    public const NAME = 'VoteId';

    /**
     * @inheritDoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?VoteId
    {
        if ($value === null || $value === '') {
            return null;
        }

        return new VoteId($value);
    }

    /**
     * @inheritDoc
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return (string) $value;
    }


    /**
     * @inheritDoc
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return DoctrineUserId::NAME;
    }

    /**
     * @inheritDoc
     */
    public function getMappedDatabaseTypes(AbstractPlatform $platform): array
    {
        return [DoctrineUserId::NAME];
    }
}
