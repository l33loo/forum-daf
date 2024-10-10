<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Exception\InvalidEmailAddress;
use JsonSerializable;
use Stringable;

/**
 * Email
 *
 * @package App\Domain\User
 */
final readonly class Email implements Stringable, JsonSerializable
{

    private string $email;

    /**
     * Creates a Email
     *
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = strtolower($email);
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailAddress("$email is not a valid email address.");
        }
    }


    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): string
    {
        return $this->email;
    }
}
