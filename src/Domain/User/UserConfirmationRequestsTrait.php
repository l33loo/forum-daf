<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Event\User\EmailConfirmationRequestWasCreated;
use App\Domain\Event\User\UserEmailWasConfirmed;
use App\Domain\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\OneToMany;
use Exception;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\ResourceAttribute;

/**
 * UserConfirmationRequestsTrait
 *
 * @package App\Domain\User
 */
trait UserConfirmationRequestsTrait
{

    /** @var Collection<int|string, EmailConfirmationRequest>|null */
    #[OneToMany(targetEntity: EmailConfirmationRequest::class, mappedBy: 'user', cascade: ['all'], orphanRemoval: true)]
    private ?Collection $emailConfirmationRequests = null;

    /**
     * Creates an email confirmation request.
     *
     * @param string|null $validityPeriod The validity period for the email confirmation request. Default is "P2D".
     * @return EmailConfirmationRequest The created email confirmation request.
     * @throws Exception
     */
    public function createEmailConfirmation(?string $validityPeriod = "P2D"): EmailConfirmationRequest
    {
        $request = new EmailConfirmationRequest($this, $validityPeriod);
        $this->emailConfirmationRequests()->add($request);
        $this->recordThat(new EmailConfirmationRequestWasCreated(
                $this->userId(),
                $request->emailConfirmationRequestId(),
                $request->expireDate())
        );
        return $request;
    }

    /**
     * Checks if the user is verified based on the email confirmation requests.
     *
     * Iterates through each email confirmation request associated with the entity.
     * If any of the confirmation requests is verified, returns true. Otherwise, returns false.
     *
     * @return bool Returns true if the entity is verified, false otherwise
     */
    #[ResourceAttribute(name: "verified")]
    public function isVerified(): bool
    {
        foreach ($this->emailConfirmationRequests as $confirmationRequest) {
            if ($confirmationRequest->isVerified() && $this->email->equals($confirmationRequest->email())) {
                return true;
            }
        }
        return false;
    }

    /**
     * Confirms the email for a given EmailConfirmationRequest.
     *
     * Loops through the email confirmation requests of the current object,
     * and if a matching valid request is found, verifies the email in the provided request.
     *
     * @param EmailConfirmationRequest $request The request to confirm the email for
     * @return UserConfirmationRequestsTrait|User This object instance after confirming the email
     */
    public function confirmEmail(EmailConfirmationRequest $request): self
    {
        $request->verify();
        $this->recordThat(new UserEmailWasConfirmed($this->email(), $request->emailConfirmationRequestId()));
        return $this;
    }

    /**
     * Returns the collection of email confirmation requests.
     *
     * If the email confirmation requests collection does not exist,
     * initializes it as a new ArrayCollection and returns it.
     *
     * @return Collection The collection of email confirmation requests
     */
    private function emailConfirmationRequests(): Collection
    {
        if (!$this->emailConfirmationRequests) {
            $this->emailConfirmationRequests = new ArrayCollection();
        }
        return $this->emailConfirmationRequests;
    }
}
