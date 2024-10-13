<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\User\Specification;

use App\Domain\Exception\EntityNotFound;
use App\Domain\User;
use App\Domain\User\UserSpecification;

/**
 * NewUserSpecification
 *
 * @package App\Domain\User\Specification
 */
class NewUserSpecification implements UserSpecification
{

    /**
     * Creates a NewUserSpecification
     *
     * @param User\UserRepository $users
     */
    public function __construct(private readonly User\UserRepository $users)
    {
    }

    /**
     * @inheritDoc
     */
    public function isSatisfiedBy(User $user): bool
    {
        try {
            $existing = $this->users->withEmail($user->email());
        } catch (EntityNotFound) {
            return true;
        }
        return $existing->userId()->equals($user->userId());
    }
}
