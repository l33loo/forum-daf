<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\User;

use App\Domain\User;
use App\Domain\User\ResetPasswordRequest;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use InvalidArgumentException;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Persistence\Repository\ResetPasswordRequestRepositoryTrait;
use SymfonyCasts\Bundle\ResetPassword\Persistence\ResetPasswordRequestRepositoryInterface;

/**
 * DoctrineResetPasswordRequestRepository
 *
 * @package App\Infrastructure\Doctrine\User
 */
final class DoctrineResetPasswordRequestRepository implements ResetPasswordRequestRepositoryInterface
{
    use ResetPasswordRequestRepositoryTrait;

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    protected function createQueryBuilder(string $alias, string|null $indexBy = null): QueryBuilder
    {
        $repository = $this->entityManager->getRepository(ResetPasswordRequest::class);
        return $repository->createQueryBuilder($alias, $indexBy);
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    protected function findOneBy(array $criteria, ?array $orderBy = null): ?ResetPasswordRequest
    {
        $repository = $this->entityManager->getRepository(ResetPasswordRequest::class);
        return $repository->findOneBy($criteria, $orderBy);
    }

    /**
     * @inheritDoc
     */
    public function createResetPasswordRequest(
        object $user,
        DateTimeInterface $expiresAt,
        string $selector,
        string $hashedToken
    ): ResetPasswordRequestInterface {
        if (!$user instanceof User) {
            throw new InvalidArgumentException('User must be an instance of User');
        }
        return new ResetPasswordRequest($user, $expiresAt, $selector, $hashedToken);
    }
}
