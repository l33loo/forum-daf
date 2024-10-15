<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Listeners;

use App\Application\User\SendEmailConfirmationCommand;
use App\Application\User\SendEmailConfirmationHandler;
use App\Domain\Event\User\UserHasRegistered;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * SendEmailConfirmationOnUserRegistered
 *
 * @package App\Application\Listeners
 */
#[AsEventListener(event: UserHasRegistered::class, method: "onRegister")]
final class SendEmailConfirmationOnUserRegistered
{

    public function __construct(private readonly SendEmailConfirmationHandler $confirmationHandler)
    {
    }

    public function onRegister(UserHasRegistered $event): void
    {
        $this->confirmationHandler->handle(new SendEmailConfirmationCommand($event->userIdentifier()));
    }
}
