<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\User;

/**
 * UserSpecification
 *
 * @package App\Domain\User
 */
interface UserSpecification
{


    /**
     * Check if the given user satisfies the conditions.
     *
     * @param User $user The user to check
     * @return bool True if the user satisfies the conditions, false otherwise
     */
    public function isSatisfiedBy(User $user): bool;
}
