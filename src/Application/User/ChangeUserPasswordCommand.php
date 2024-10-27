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
use SensitiveParameter;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\ResourceAttribute;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\ResourceIdentifier;

/**
 * ChangeUserPasswordCommand
 *
 * @package App\Application\User
 */
#[AsResourceObject(type: "users")]
final readonly class ChangeUserPasswordCommand
{


    /**
     * Creates a ChangeUserPasswordCommand
     *
     * @param UserId $userId The UserId object for the user
     * @param string $password The password for user authentication
     */
    public function __construct(
        #[ResourceIdentifier(className: UserId::class)]
        private UserId $userId,
        #[SensitiveParameter]
        #[ResourceAttribute(required: true)]
        private string $password
    ) {
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * Gets the password for user authentication
     *
     * @return string The password for user authentication
     */
    public function password(): string
    {
        return $this->password;
    }

}
