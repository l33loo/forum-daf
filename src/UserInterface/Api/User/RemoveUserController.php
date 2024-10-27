<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\User;

use App\Application\User\RemoveUserAccountCommand;
use App\Application\User\RemoveUserAccountHandler;
use App\Domain\User;
use App\Domain\User\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * RemoveUserController
 *
 * @package App\UserInterface\Api\User
 */
final class RemoveUserController extends AbstractController
{


    #[Route(path: "/api/user/{userId}", name: "api-remove-user", methods: ['DELETE'])]
    #[IsGranted(User::ROLE_ADMIN)]
    public function remove(string $userId, RemoveUserAccountHandler $handler): Response
    {
        $handler->handle(new RemoveUserAccountCommand(new UserId($userId)));
        return new Response(status: 204);
    }
}
