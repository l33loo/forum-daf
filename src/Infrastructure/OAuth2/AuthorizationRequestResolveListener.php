<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\OAuth2;

use League\Bundle\OAuth2ServerBundle\Event\AuthorizationRequestResolveEvent;
use League\Bundle\OAuth2ServerBundle\ValueObject\Scope;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * AuthorizationRequestResolveListener
 *
 * @package App\Infrastructure\OAuth2
 */
#[AsEventListener(event: "league.oauth2_server.event.authorization_request_resolve", method: "onResolve")]
final class AuthorizationRequestResolveListener
{

    public function onResolve(AuthorizationRequestResolveEvent $event): void
    {
        $roles = $event->getUser()->getRoles();
        /** @var Scope[] $scopes */
        $scopes = $event->getScopes();
        $authorize = false;
        foreach ($scopes as $scope) {
            foreach ($roles as $role) {
                if (str_contains($role, (string) $scope)) {
                    $authorize = true;
                }
            }
        }
        $event->resolveAuthorization($authorize);
    }
}
