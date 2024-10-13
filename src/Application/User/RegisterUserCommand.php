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
use SensitiveParameter;

/**
 * RegisterUserCommand
 *
 * @package App\Application\User
 */
final readonly class RegisterUserCommand
{


    /**
     * Creates a RegisterUserCommand
     *
     * @param Email $email
     * @param string|null $name
     * @param string|null $password
     */
    public function __construct(
        private Email $email,
        private ?string $name = null,
        #[SensitiveParameter]
        private ?string $password = null
    ) {
    }

    /**
     * RegisterUserCommand email
     *
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * RegisterUserCommand name
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->name;
    }

    /**
     * RegisterUserCommand password
     *
     * @return string|null
     */
    public function password(): ?string
    {
        return $this->password;
    }
}
