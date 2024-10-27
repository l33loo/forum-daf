<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\User;

use App\Application\User\UpdateUserCommand;
use App\Application\User\UpdateUserHandler;
use App\Domain\User;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * UpdateUserController
 *
 * @package App\UserInterface\Api\User
 */
final class UpdateUserController extends AbstractController
{
    use ApiControllerMethods;

    public function __construct(private readonly UpdateUserHandler $handler)
    {
    }

    #[Route(path: "/api/user/{userId}", name: "api-update-user", methods: ["PATCH", "POST"])]
    #[IsGranted(User::ROLE_USER)]
    public function handle(string $userId): Response
    {
        $command = $this->decodeTo(UpdateUserCommand::class);
        $user = $this->handler->handle($command);
        return $this->apiResponse($user);
    }
}
