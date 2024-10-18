<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Listeners;

use App\Application\User\SendEmailConfirmationHandler;
use App\Application\User\SendUpdateEmailConfirmationCommand;
use App\Domain\Event\User\UserEmailHasChanged;
use App\Domain\User\UserRepository;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * SendEmailConfirmationOnEmailUpdate
 *
 * @package App\Application\Listeners
 */
#[AsEventListener(event: UserEmailHasChanged::class, method: "onUserEmailHasChanged")]
final class SendEmailConfirmationOnEmailUpdate
{

    public function __construct(
        private readonly SendEmailConfirmationHandler $confirmationHandler,
        private readonly UserRepository $users
    ) {
    }

    public function onUserEmailHasChanged(UserEmailHasChanged $event): void
    {
        $user = $this->users->withId($event->userId());
        if ($user->isVerified()) {
            return;
        }

        $this->confirmationHandler->handle(new SendUpdateEmailConfirmationCommand($event->userId()));
    }
}
