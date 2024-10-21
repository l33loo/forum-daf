<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Web\User;

use App\Domain\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Twig\Environment;

/**
 * BannedUserRequestListener
 *
 * @package App\UserInterface\Web\User
 */
#[AsEventListener(event: "kernel.request", method: "onKernelRequest")]
final class BannedUserRequestListener
{

    public function __construct(
        private readonly Security $security,
        private readonly Environment $environment
    ) {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $user = $this->security->getUser();
        if ($user instanceof User && $user->isBanned()) {
            $event->setResponse(
                new Response(
                    content: $this->environment->render('user/banned.html.twig', compact(['user'])),
                    status: Response::HTTP_FORBIDDEN,
                )
            );
            $event->stopPropagation();
        }
    }
}
