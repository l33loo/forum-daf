<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\Exception\FailedSpecification;
use App\Domain\User;
use App\Domain\User\Specification\CanVerifyEmailSpecification;
use App\Domain\User\UserRepository;
use Slick\Event\EventDispatcher;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * ConfirmUserEmailHandler
 *
 * @package App\Application\User
 */
final readonly class ConfirmUserEmailHandler
{


    /**
     * Class constructor.
     *
     * @param UserRepository $users Repository for managing users
     * @param CanVerifyEmailSpecification $canVerifyEmailSpec Specification for verifying email
     * @param EventDispatcher $eventDispatcher Dispatcher for handling events
     */
    public function __construct(
        private UserRepository $users,
        private CanVerifyEmailSpecification $canVerifyEmailSpec,
        private TranslatorInterface $translator,
        private EventDispatcher $eventDispatcher
    ) {
    }

    public function handle(ConfirmUserEmailCommand $command): User
    {
        $request = $this->users->emailConfirmationToken($command->token());
        $user = $this->users->currentLoggedInUser();

        if (!$this->canVerifyEmailSpec->isSatisfiedBy($request)) {
            throw new FailedSpecification(
                $this->translator->trans(
                    "Validation token has expired. Please request a new email confirmation.",
                )
            );
        }

        $this->eventDispatcher->dispatchEventsFrom(
            $user->confirmEmail($request)
        );

        return $user;
    }


}
