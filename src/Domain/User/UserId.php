<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Exception\InvalidIdentifier;
use JsonSerializable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Stringable;

/**
 * UserId
 *
 * @package App\Domain\User
 */
final class UserId implements Stringable, JsonSerializable
{
    private UuidInterface $uuid;

    /**
     * Creates a UserId
     *
     * @param string|null $identifier
     */
    public function __construct(?string $identifier = null)
    {
        if ($identifier && !Uuid::isValid($identifier)) {
            throw new InvalidIdentifier('Invalid user identifier');
        }
        $this->uuid = $identifier ? Uuid::fromString($identifier) : Uuid::uuid4();
    }


    /**
     * Returns the string representation of the object.
     *
     * @return string The string representation of the object.
     */
    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): string
    {
        return $this->uuid->toString();
    }
}
