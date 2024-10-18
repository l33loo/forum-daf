<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\User\Email;
use App\Domain\User\UserId;

/**
 * UpdateUserCommand
 *
 * @package App\Application\User
 */
final readonly class UpdateUserCommand
{


    /**
     * Creates a UpdateUserCommand
     *
     * @param UserId $userId
     * @param string|null $name
     * @param Email $email
     */
    public function __construct(
        private UserId $userId,
        private string|null $name,
        private Email $email
    ) {
    }

    /**
     * UpdateUserCommand userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * UpdateUserCommand name
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->name;
    }

    /**
     * UpdateUserCommand email
     *
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }
}
