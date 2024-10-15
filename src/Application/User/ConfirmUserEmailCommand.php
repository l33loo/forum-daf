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
 * ConfirmUserEmailCommand
 *
 * @package App\Application\User
 */
final readonly class ConfirmUserEmailCommand
{


    /**
     * Creates a ConfirmUserEmailCommand
     *
     * @param string $token
     */
    public function __construct(private string $token)
    {
    }


    /**
     * ConfirmUserEmailCommand token
     *
     * @return string
     */
    public function token(): string
    {
        return $this->token;
    }
}
