<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\Comment;

use App\Application\Comment\ChangeCommentCommand;
use App\Application\Comment\ChangeCommentHandler;
use App\Domain\DomainException;
use App\Domain\Comment\CommentId;
use App\Domain\User;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * ChangeCommentController
 *
 * @package App\UserInterface\Api\Comment
 */
final class ChangeCommentController extends AbstractController
{
    use ApiControllerMethods;

    public function __construct(private readonly ChangeCommentHandler $handler)
    {}

    /**
     * @throws DomainException
     */
    #[Route(path: '/api/comment/{commentId}', name: 'api-change-comment', methods: ['PATCH', 'PUT'])]
    #[IsGranted(User::ROLE_USER)]
    public function handle(CommentId $commentId): Response
    {
        $command = $this->decodeTo(ChangeCommentCommand::class);
        $comment = $this->handler->handle($command);
        return $this->apiResponse(
            $comment,
            Response::HTTP_NO_CONTENT,
            [
                "location" => $this->generateUrl('api-read-comment', ['commentId' => $comment->commentId()])
            ]
        );
    }
}
