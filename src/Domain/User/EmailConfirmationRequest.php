<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\User;
use DateInterval;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Exception;
use Stringable;

/**
 * EmailConfirmationRequest
 *
 * @package App\Domain\User
 */
#[Entity]
#[Table(name: 'email_confirmation_requests')]
class EmailConfirmationRequest implements Stringable
{

    #[Id]
    #[GeneratedValue(strategy: 'NONE')]
    #[Column(name: 'id', type: 'EmailConfirmationRequestId')]
    private User\EmailConfirmationRequest\EmailConfirmationRequestId $emailConfirmationRequestId;
    #[Column(name: 'expire_date', type: 'datetime_immutable')]
    private DateTimeImmutable $expireDate;

    #[Column]
    private bool $verified = false;

    #[Column(type: "Email")]
    private Email $email;


    /**
     * @throws Exception
     */
    public function __construct(
        #[ManyToOne(targetEntity: User::class, inversedBy: "emailConfirmationRequests")]
        #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
        private readonly User $user,
        ?string $validityPeriod = "PT2H"
    ) {
        $this->emailConfirmationRequestId = new User\EmailConfirmationRequest\EmailConfirmationRequestId();
        $this->expireDate = (new DateTimeImmutable())->add(new DateInterval($validityPeriod ?? "PT2H"));
        $this->email = $this->user->email();
    }

    /**
     * EmailConfirmationRequest emailConfirmationRequestId
     *
     * @return EmailConfirmationRequest\EmailConfirmationRequestId
     */
    public function emailConfirmationRequestId(): EmailConfirmationRequest\EmailConfirmationRequestId
    {
        return $this->emailConfirmationRequestId;
    }

    /**
     * EmailConfirmationRequest expireDate
     *
     * @return DateTimeImmutable
     */
    public function expireDate(): DateTimeImmutable
    {
        return $this->expireDate;
    }

    /**
     * EmailConfirmationRequest user
     *
     * @return User
     */
    public function user(): User
    {
        return $this->user;
    }

    /**
     * EmailConfirmationRequest email
     *
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }


    /**
     * Check if the expiration date is valid
     *
     * @return bool
     */
    public function isValid(): bool
    {
        $now = new DateTimeImmutable();
        return $now < $this->expireDate;
    }

    /**
     * Check if the entity is verified
     *
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->verified;
    }

    /**
     * Verify the request.
     *
     * @return self
     */
    public function verify(): self
    {
        $this->verified = true;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return (string) $this->emailConfirmationRequestId;
    }
}
