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

/**
 * RequestPasswordResetCommand
 *
 * @package App\Application\User
 */
final readonly class RequestPasswordResetCommand
{


    public function __construct(private Email $email)
    {
    }

    /**
     * RequestPasswordResetCommand email
     *
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }
}
