<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\User;

use App\Application\User\BanUserCommand;
use App\Application\User\BanUserHandler;
use App\Domain\User;
use App\Domain\User\UserId;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * BanUserController
 *
 * @package App\UserInterface\Api\User
 */
final class BanUserController extends AbstractController
{

    use ApiControllerMethods;

    #[Route(path: "/api/user/{userId}/ban", name: "api-ban-user", methods: ["POST"])]
    #[IsGranted(User::ROLE_ADMIN)]
    public function banUser(BanUserHandler $handler): Response
    {
        $command = $this->decodeTo(BanUserCommand::class);
        $user = $handler->handle($command);
        return $this->apiResponse($user);
    }

}
