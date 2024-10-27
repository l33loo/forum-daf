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
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\ResourceAttribute;

/**
 * CreateUserCommand
 *
 * @package App\Application\User
 */
#[AsResourceObject(type: 'users')]
final readonly class CreateUserCommand
{


    /**
     * Creates a Create User Command
     *
     * @param Email $email The email object to be used.
     * @param string|null $name The optional name associated with the email.
     */
    public function __construct(
        #[ResourceAttribute(className: Email::class, required: true)]
        private Email $email,
        #[ResourceAttribute]
        private ?string $name = null)
    {
    }

    /**
     * Gets the email object associated with this instance.
     *
     * @return Email The email object associated with this instance.
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * Gets the name associated with the email.
     *
     * @return string|null The name associated with the email, or null if no name is set.
     */
    public function name(): ?string
    {
        return $this->name;
    }
}
