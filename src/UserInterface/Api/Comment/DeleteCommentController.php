<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\Comment;

use App\Application\Comment\DeleteCommentCommand;
use App\Application\Comment\DeleteCommentHandler;
use App\Domain\DomainException;
use App\Domain\Comment\CommentId;
use App\Domain\User;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * DeleteCommentController
 *
 * @package App\UserInterface\Api\Comment
 */
final class DeleteCommentController extends AbstractController
{
    use ApiControllerMethods;

    public function __construct(private readonly DeleteCommentHandler $handler)
    {}

    /**
     * @throws DomainException
     */
    #[Route(path: '/api/comment/{commentId}', name: 'api-delete-comment', methods: ['DELETE'])]
    #[IsGranted(User::ROLE_USER)]
    public function handle(CommentId $commentId): Response
    {
        $command = $this->decodeTo(DeleteCommentCommand::class);
        $comment = $this->handler->handle($command);
        return $this->apiResponse(
            $comment,
            Response::HTTP_NO_CONTENT,
            [
                // TODO: fix this
                "location" => $this->generateUrl('api-read-comment', ['commentId' => $comment->commentId()])
            ]
        );
    }
}
