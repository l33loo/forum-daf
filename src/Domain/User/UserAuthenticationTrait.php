<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\User;

use Doctrine\ORM\Mapping\Column;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\ResourceAttribute;

/**
 * UserAuthenticationTrait
 *
 * @package App\Domain\User
 */
trait UserAuthenticationTrait
{

    /** @var array<string>  */
    #[Column(type: "json")]
    private array $roles = [];


    #[Column(nullable: true)]
    private ?string $password = null;

    /**
     * @inheritDoc
     */
    #[ResourceAttribute(name: "roles")]
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = self::ROLE_USER;
        if ($this->isVerified()) {
            $roles[] = self::ROLE_VERIFIED_USER;
        }
        return array_unique($roles);
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials(): void
    {
        // do nothing
    }

    /**
     * @inheritDoc
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @inheritDoc
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }
}
