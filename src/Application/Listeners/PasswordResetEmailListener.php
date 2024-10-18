<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Listeners;

use App\Application\User\SendPasswordResetEmailCommand;
use App\Application\User\SendPasswordResetEmailHandler;
use App\Domain\Event\User\PasswordResetWasRequested;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * PasswordResetEmailListener
 *
 * @package App\Application\Listeners
 */
#[AsEventListener(event: PasswordResetWasRequested::class, method: "onPasswordResetWasRequested")]
final readonly class PasswordResetEmailListener
{
    /**
     * Creates a PasswordResetEmailListener
     *
     * @param SendPasswordResetEmailHandler $handler The handler for sending password reset emails.
     */
    public function __construct(private SendPasswordResetEmailHandler $handler)
    {
    }


    /**
     * Handles the PasswordResetWasRequested event by sending a password reset email.
     *
     * @param PasswordResetWasRequested $event The event object containing user ID and token information.
     */
    public function onPasswordResetWasRequested(PasswordResetWasRequested $event): void
    {
        $this->handler->handle(new SendPasswordResetEmailCommand($event->userId(), $event->token()));
    }
}
