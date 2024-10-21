<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Common\Equatable;
use App\Domain\Event\User\UserEmailHasChanged;
use App\Domain\Event\User\UserHasChanged;
use App\Domain\Event\User\UserHasChangedPassword;
use App\Domain\Event\User\UserHasRegistered;
use App\Domain\Event\User\UserWasCreated;
use App\Domain\User\BanUserMethods;
use App\Domain\User\Email;
use App\Domain\User\PromoteUserMethods;
use App\Domain\User\UserAuthenticationTrait;
use App\Domain\User\UserConfirmationRequestsTrait;
use App\Domain\User\UserId;
use Doctrine\Common\Collections\ArrayCollection;
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
class User implements UserInterface, PasswordAuthenticatedUserInterface, EventGenerator, Equatable
{

    use EventGeneratorMethods;
    use UserConfirmationRequestsTrait;
    use UserAuthenticationTrait;
    use BanUserMethods;
    use PromoteUserMethods;

    public const ROLE_USER = 'ROLE_OAUTH2_USER';
    public const ROLE_VERIFIED_USER = 'ROLE_OAUTH2_VERIFIED_USER';
    public const ROLE_ADMIN = 'ROLE_OAUTH2_ADMIN';

    #[Id]
    #[GeneratedValue(strategy: 'NONE')]
    #[Column(name: 'id', type: 'UserId')]
    #[ResourceIdentifier(className: UserId::class)]
    private UserId $userId;


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
        $this->emailConfirmationRequests = new ArrayCollection();
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

    /**
     * @inheritDoc
     */
    public function equals(object $other): bool
    {
        if ($other instanceof self) {
            return $this->userId->equals($other->userId);
        }
        return false;
    }

    /**
     * Updates the name and email of the user
     *
     * @param string $name The new name of the user
     * @param Email $updatedEmail The updated email of the user
     * @return self
     */
    public function update(string $name, Email $updatedEmail): self
    {
        $oldEmail = $this->email;
        $this->name = $name;
        $this->email = $updatedEmail;
        $this->recordThat(new UserHasChanged($this->userId, $name, $updatedEmail));
        if (!$oldEmail->equals($updatedEmail)) {
            $this->recordThat(new UserEmailHasChanged($this->userId, $oldEmail, $updatedEmail));
        }
        return $this;
    }
}
