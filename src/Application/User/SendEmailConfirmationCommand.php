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
 * SendEmailConfirmationCommand
 *
 * @package App\Application\User
 */
readonly class SendEmailConfirmationCommand
{


    /**
     * Creates a SendEmailConfirmationCommand
     *
     * @param UserId $userId
     */
    public function __construct(private UserId $userId)
    {
    }

    /**
     * SendEmailConfirmationCommand userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }
}
