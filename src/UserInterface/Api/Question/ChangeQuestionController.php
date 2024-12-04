<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\Question;

use App\Application\Question\ChangeQuestionCommand;
use App\Application\Question\ChangeQuestionHandler;
use App\Domain\DomainException;
use App\Domain\Question\QuestionId;
use App\Domain\User;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * ChangeQuestionController
 *
 * @package App\UserInterface\Api\Question
 */
final class ChangeQuestionController extends AbstractController
{
    use ApiControllerMethods;

    public function __construct(private readonly ChangeQuestionHandler $handler)
    {}

    /**
     * @throws DomainException
     */
    #[Route(path: '/api/question/{questionId}', name: 'api-change-question', methods: ['PATCH', 'PUT'])]
    #[IsGranted(User::ROLE_USER)]
    public function handle(string $questionId): Response
    {
        $command = $this->decodeTo(ChangeQuestionCommand::class);
        $question = $this->handler->handle($command);
        return $this->apiResponse(
            $question,
            Response::HTTP_OK,
            [
                "location" => $this->generateUrl('api-read-question', ['questionId' => $question->question()])
            ]
        );
    }
}
