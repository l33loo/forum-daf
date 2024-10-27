<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Mapping\Question;

use App\Domain\Question\QuestionId;
use App\Infrastructure\Doctrine\Mapping\User\DoctrineUserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

/**
 * DoctrineQuestionId
 *
 * @package App\Infrastructure\Doctrine\Mapping\Question
 */
final class DoctrineQuestionId extends GuidType
{
    public const NAME = 'QuestionId';

    /**
     * @inheritDoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?QuestionId
    {
        if ($value === null || $value === '') {
            return null;
        }

        return new QuestionId($value);
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
