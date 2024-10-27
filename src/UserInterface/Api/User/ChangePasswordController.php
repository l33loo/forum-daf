<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\User;

use App\Application\User\ChangeUserPasswordCommand;
use App\Application\User\ChangeUserPasswordHandler;
use App\Domain\User;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * ChangePasswordController
 *
 * @package App\UserInterface\Api\User
 */
final class ChangePasswordController extends AbstractController
{

    use ApiControllerMethods;

    public function __construct(private readonly ChangeUserPasswordHandler $handler)
    {
    }

    #[Route(path: "/api/user/{userId}/change-password", name: "api-user-change-password", methods: ["PATCH", "POST"])]
    #[IsGranted(User::ROLE_USER)]
    public function handler(string $userId): Response
    {
        $command = $this->decodeTo(ChangeUserPasswordCommand::class);
        $user = $this->handler->handle($command);
        return $this->apiResponse($user);
    }
}
