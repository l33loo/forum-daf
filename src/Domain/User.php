<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Event\User\UserHasChangedPassword;
use App\Domain\Event\User\UserHasRegistered;
use App\Domain\Event\User\UserWasCreated;
use App\Domain\User\Email;
use App\Domain\User\UserId;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use SensitiveParameter;
use Slick\Event\Domain\EventGeneratorMethods;
use Slick\Event\EventGenerator;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\ResourceAttribute;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\ResourceIdentifier;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @package App\Domain
 */
#[Entity]
#[Table(name: "users")]
#[AsResourceObject(type: "users")]
class User implements UserInterface, PasswordAuthenticatedUserInterface, EventGenerator
{

    use EventGeneratorMethods;

    public const ROLE_USER = 'ROLE_OAUTH2_USER';
    public const ROLE_ADMIN = 'ROLE_OAUTH2_ADMIN';

    #[Id]
    #[GeneratedValue(strategy: 'NONE')]
    #[Column(name: 'id', type: 'UserId')]
    #[ResourceIdentifier(className: UserId::class)]
    private UserId $userId;

    /** @var array<string>  */
    #[Column(type: "json")]
    private array $roles = [];

    #[Column(nullable: true)]
    private ?string $password = null;

    /**
     * Creates a user
     *
     * @param Email $email The email of the user
     * @param string|null $name The name of the user
     */
    public function __construct(
        #[Column(type: "Email", length: 180, unique: true)]
        #[ResourceAttribute(className: Email::class)]
        private Email $email,
        #[Column(nullable: true)]
        #[ResourceAttribute]
        private ?string $name = null
    ) {
        $this->userId = new UserId();
        $this->recordThat(new UserWasCreated($this->userId, $this->email, $this->name));
    }

    /**
     * Registers a new user with the provided email, name, and hashed password.
     *
     * @param Email $email The email of the user
     * @param string|null $name The name of the user
     * @param string|null $hashedPassword The hashed password of the user
     * @return self The newly registered user object
     */
    public static function register(
        Email $email,
        ?string $name = null,
        #[SensitiveParameter]
        ?string $hashedPassword = null
    ): self {
        $user = new self($email, $name);
        $user->password = $hashedPassword;
        $user->releaseEvents();
        $user->recordThat(new UserHasRegistered(
            $user->userId,
            $email,
            $name,
            $hashedPassword
        ));
        return $user;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }


    /**
     * Get the name of the user
     *
     * @return string|null The name of the user
     */
    public function name(): ?string
    {
        return $this->name;
    }

    /**
     * Get the email of the user
     *
     * @return Email The email object of the user
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    #[ResourceAttribute(name: "roles")]
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = self::ROLE_USER;
        return array_unique($roles);
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials(): void
    {
        $this->password = null;
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

    /**
     * Sets the password for this user and returns it.
     *
     * @param string $password The password to set
     * @return self The updated entity
     */
    public function withPassword(#[SensitiveParameter] string $password): self
    {
        $this->password = $password;
        $this->recordThat(new UserHasChangedPassword($this->userId, $password));
        return $this;
    }
}
