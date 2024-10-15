<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Common;

use App\Domain\Exception\InvalidIdentifier;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * EntityIdentifierMethods
 *
 * @package App\Domain\Common
 */
trait EntityIdentifierMethods
{
    private UuidInterface $uuid;

    /**
     * Creates a UserId
     *
     * @param string|null $identifier
     */
    public function __construct(?string $identifier = null)
    {
        $className = get_called_class();
        $parts = explode('\\', $className);
        $name = array_pop($parts);
        if ($identifier && !Uuid::isValid($identifier)) {
            throw new InvalidIdentifier("Invalid $name identifier");
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

    /**
     * @inheritDoc
     */
    public function equals(object $other): bool
    {
        if ($other instanceof self) {
            return $this->uuid->equals($other->uuid);
        }
        return false;
    }
}
