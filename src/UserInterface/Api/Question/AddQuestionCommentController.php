<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\Question;

use App\Application\Question\AddQuestionCommentCommand;
use App\Application\Question\AddQuestionCommentHandler;
use App\Domain\DomainException;
use App\Domain\Question\QuestionId;
use App\Domain\User;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * AddQuestionCommentController
 *
 * @package App\UserInterface\Api\Question
 */
final class AddQuestionCommentController extends AbstractController
{
    use ApiControllerMethods;

    public function __construct(private readonly AddQuestionCommentHandler $handler)
    {}

    /**
     * @throws DomainException
     */
    #[Route(path: '/api/question/{questionId}/add-comment', name: 'api-add-question-comment', methods: ['PATCH'])]
    #[IsGranted(User::ROLE_USER)]
    public function handle(string $questionId): Response
    {
        $command = $this->decodeTo(AddQuestionCommentCommand::class);
        $question = $this->handler->handle($command);
        return $this->apiResponse(
            $question,
            Response::HTTP_OK,
            [
                "location" => $this->generateUrl('api-read-question', ['questionId' => $question->questionId()])
            ]
        );
    }
}
