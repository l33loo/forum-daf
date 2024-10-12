<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Events;

use App\Domain\Event\User\UserHasLoggedIn;
use Slick\Event\EventDispatcher;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

/**
 * UserLoginListener
 *
 * @package App\Infrastructure\Events
 */
#[AsEventListener(event: LoginSuccessEvent::class, method: "onLoginSuccess")]
final readonly class UserLoginListener
{

    public function __construct(private EventDispatcher $dispatcher)
    {
    }

    /**
     * Triggered when a user successfully logs in.
     *
     * @param LoginSuccessEvent $event The event object containing information about the login success.
     *
     * @return void
     */
    public function onLoginSuccess(LoginSuccessEvent $event): void
    {
        if ($event->getFirewallName() !== "main") {
            return;
        }

        $this->dispatcher->dispatch(new UserHasLoggedIn($event->getUser()->userId()));
    }
}
