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
 * SendPasswordResetEmailCommand
 *
 * @package App\Application\User
 */
final readonly class SendPasswordResetEmailCommand
{


    /**
     * Creates a SendPasswordResetEmailCommand
     *
     * @param UserId $userId The user ID object being injected.
     * @param string $token The token string being injected.
     */
    public function __construct(
        private UserId $userId,
        private string $token,
    ) {
    }

    /**
     * SendPasswordResetEmailCommand userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * SendPasswordResetEmailCommand token
     *
     * @return string
     */
    public function token(): string
    {
        return $this->token;
    }
}
