<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Events;

use App\Domain\Event\User\UserHasLoggedOut;
use Slick\Event\EventDispatcher;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\LogoutEvent;

/**
 * UserLogoutListener
 *
 * @package App\Infrastructure\Events
 */
#[AsEventListener(event: LogoutEvent::class, method: 'onLogout')]
final class UserLogoutListener
{

    public function __construct(private EventDispatcher $dispatcher)
    {
    }

    public function onLogout(LogoutEvent $event): void
    {
        $this->dispatcher->dispatch(new UserHasLoggedOut($event->getToken()->getUser()->userId()));
    }
}
