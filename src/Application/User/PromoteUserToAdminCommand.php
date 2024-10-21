<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\User\UserId;

/**
 * PromoteUserToAdminCommand
 *
 * @package App\Application\User
 */
readonly class PromoteUserToAdminCommand
{


    public function __construct(private UserId $userId)
    {
    }

    /**
     * PromoteUserToAdminCommand userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }
}
