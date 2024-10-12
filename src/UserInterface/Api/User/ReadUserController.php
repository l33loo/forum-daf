<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\User;

use Slick\JSONAPI\Document\DocumentEncoder;
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

    public function __construct(private DocumentEncoder $encoder)
    {
    }

    #[Route(path: '/api/me', name: 'read_current_user', methods: ['GET'])]
    public function me(Security $security): Response
    {
        $user = $security->getUser();
        return new Response(
            content: $this->encoder->encode($user),
            headers: ['Content-Type' => 'application/vnd.api+json']
        );
    }
}
