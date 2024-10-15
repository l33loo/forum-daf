<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\User\Specification;

use App\Domain\Exception\FailedSpecification;
use App\Domain\User\EmailConfirmationRequest;
use App\Domain\User\UserRepository;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * CanVerifyEmailSpecification
 *
 * @package App\Domain\User\Specification
 */
class CanVerifyEmailSpecification
{


    /**
     * Creates a "Can verify email" specification
     *
     * @param UserRepository $users The userRepository object.
     */
    public function __construct(
        private UserRepository $users
    ) {
    }

    public function isSatisfiedBy(EmailConfirmationRequest $request): bool
    {
        if (!$request->isValid()) {
            return false;
        }

        return $request->user()->equals($this->users->currentLoggedInUser());
    }

}
