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
 * RemoveUserAccountCommand
 *
 * @package App\Application\User
 */
final readonly class RemoveUserAccountCommand
{


    public function __construct(private UserId $userId)
    {
    }

    /**
     * RemoveUserAccountCommand userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }
}
