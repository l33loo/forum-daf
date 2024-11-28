<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\Tag;

use App\Application\Tag\EditTagCommand;
use App\Application\Tag\EditTagHandler;
use App\Domain\User;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * EditTagController
 *
 * @package App\UserInterface\Api\Tag
 */
final class EditTagController extends AbstractController
{
    use ApiControllerMethods;

    public function __construct(private readonly EditTagHandler $handler)
    {}

    #[Route(path: '/api/tag/{tagId}', name: 'api-edit-tag', methods: ['PATCH', 'POST'])]
    #[IsGranted(User::ROLE_ADMIN)]
    public function handle(string $tagId): Response
    {
        $command = $this->decodeTo(EditTagCommand::class);
        $tag = $this->handler->handle($command);
        return $this->apiResponse($tag);
    }
}