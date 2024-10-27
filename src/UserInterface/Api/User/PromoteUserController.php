<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\User;

use App\Application\User\DemoteUserFromAdminCommand;
use App\Application\User\DemoteUserFromAdminHandler;
use App\Application\User\PromoteUserToAdminCommand;
use App\Application\User\PromoteUserToAdminHandler;
use App\Domain\User;
use App\Domain\User\UserId;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * PromoteUserController
 *
 * @package App\UserInterface\Api\User
 */
final class PromoteUserController extends AbstractController
{

    use ApiControllerMethods;

    #[Route(path: "/api/user/{userId}/promote", name: "api-promote-user", methods: ['POST'])]
    #[IsGranted(User::ROLE_ADMIN)]
    public function promote(string $userId, PromoteUserToAdminHandler $handler): Response
    {
        $user = $handler->handle(new PromoteUserToAdminCommand(new UserId($userId)));
        return $this->apiResponse($user);
    }

    #[Route(path: "/api/user/{userId}/demote", name: "api-demote-user", methods: ['POST'])]
    #[IsGranted(User::ROLE_ADMIN)]
    public function demote(string $userId, DemoteUserFromAdminHandler $handler): Response
    {
        $user = $handler->handle(new DemoteUserFromAdminCommand(new UserId($userId)));
        return $this->apiResponse($user);
    }
}
