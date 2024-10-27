<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\User;

use App\Application\User\CreateUserCommand;
use App\Application\User\CreateUserHandler;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * CreateUserController
 *
 * @package App\UserInterface\Api\User
 */
final class CreateUserController extends AbstractController
{

    use ApiControllerMethods;

    public function __construct(private readonly CreateUserHandler $handler)
    {
    }

    #[Route(path: "/api/user", name: "api-create-user", methods: ["POST"])]
    public function handle(): Response
    {
        $command = $this->decodeTo(CreateUserCommand::class);
        $user = $this->handler->handle($command);
        return $this->apiResponse(
            $user,
            Response::HTTP_CREATED,
            ['Location' => $this->generateUrl('api-read-user', ['userId' => $user->userId()])]
        );
    }
}
