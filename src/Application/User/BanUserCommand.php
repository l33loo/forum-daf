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
 * BanUserCommand
 *
 * @package App\Application\User
 */
final readonly class BanUserCommand
{


    public function __construct(
        private UserId $userId,
        private string $reason
    ) {
    }

    /**
     * BanUserCommand userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * BanUserCommand reason
     *
     * @return string
     */
    public function reason(): string
    {
        return $this->reason;
    }
}
