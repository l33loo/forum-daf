<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\User;

use App\Domain\DomainException;
use App\Domain\Exception\EntityNotFound;
use App\Domain\User;
use App\Domain\User\Email;
use App\Domain\User\UserId;
use App\Domain\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * DoctrineUserRepository
 *
 * @package App\Infrastructure\Doctrine\User
 */
final readonly class DoctrineUserRepository implements UserRepository, UserProviderInterface, PasswordUpgraderInterface
{

    /**
     * Creates a DoctrineUserRepository
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @inheritDoc
     */
    public function add(User $user): User
    {
        $this->entityManager->persist($user);
        return $user;
    }

    /**
     * Retrieves a User entity by its ID
     *
     * @param UserId $userId The unique identifier of the User
     * @return User The User entity if found
     * @throws EntityNotFound|DomainException When no user is found for provided identifier
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function withId(UserId $userId): User
    {
        $user = $this->entityManager->find(User::class, $userId);
        if ($user instanceof User) {
            return $user;
        }

        throw new EntityNotFound("User not found");
    }

    /**
     * @inheritDoc
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    /**
     * @inheritDoc
     */
    public function supportsClass(string $class): bool
    {
        return User::class === $class;
    }

    /**
     * @inheritDoc
     */
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $email = new User\Email($identifier);
        return $this->withEmail($email);
    }

    /**
     * @inheritDoc
     * @param PasswordAuthenticatedUserInterface|User $user
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        $user->withPassword($newHashedPassword);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function withEmail(Email $email): User
    {
        $repository = $this->entityManager->getRepository(User::class);
        $user = $repository->findOneBy(["email" => $email]);
        if ($user instanceof User) {
            return $user;
        }

        throw new EntityNotFound("There is no user with the email $email");
    }
}
