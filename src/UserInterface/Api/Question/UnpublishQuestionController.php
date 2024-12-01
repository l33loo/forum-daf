<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\Question;

use App\Application\Question\UnpublishQuestionCommand;
use App\Application\Question\UnpublishQuestionHandler;
use App\Domain\DomainException;
use App\Domain\Question\QuestionId;
use App\Domain\User;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * UnpublishQuestionController
 *
 * @package App\UserInterface\Api\Question
 */
final class UnpublishQuestionController extends AbstractController
{
    use ApiControllerMethods;

    public function __construct(private readonly UnpublishQuestionHandler $handler)
    {}

    /**
     * @throws DomainException
     */
    #[Route(path: '/api/question/{questionId}', name: 'api-post-question', methods: ['PATCH'])]
    #[IsGranted(User::ROLE_ADMIN)]
    public function handle(QuestionId $questionId): Response
    {
        $command = $this->decodeTo(UnpublishQuestionCommand::class);
        $question = $this->handler->handle($command);
        return $this->apiResponse(
            $question,
            Response::HTTP_NO_CONTENT,
            [
                "location" => $this->generateUrl('api-read-question', ['questionId' => $question->question()])
            ]
        );
    }
}
