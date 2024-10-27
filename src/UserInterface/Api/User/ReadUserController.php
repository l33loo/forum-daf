<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\User;

use App\Domain\User\UserId;
use App\Domain\User\UserRepository;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * ReadUserController
 *
 * @package App\UserInterface\Api\User
 */
final class ReadUserController extends AbstractController
{

    use ApiControllerMethods;

    #[Route(path: '/api/me', name: 'api-read-current-user', methods: ['GET'])]
    public function me(Security $security): Response
    {
        $user = $security->getUser();
        return $this->apiResponse($user);
    }

    #[Route(path: '/api/user/{userId}', name: 'api-read-user', methods: ['GET'])]
    public function read(string $userId, UserRepository $users): Response
    {
        $user = $users->withId(new UserId($userId));
        return $this->apiResponse($user);
    }
}
