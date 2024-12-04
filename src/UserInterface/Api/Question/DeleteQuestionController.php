<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\Question;

use App\Application\Question\RemoveQuestionCommand;
use App\Application\Question\RemoveQuestionHandler;
use App\Domain\DomainException;
use App\Domain\Question\QuestionId;
use App\Domain\User;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * DeleteQuestionController
 *
 * @package App\UserInterface\Api\Question
 */
final class DeleteQuestionController extends AbstractController
{
    use ApiControllerMethods;

    public function __construct(private readonly RemoveQuestionHandler $handler)
    {}

    /**
     * @throws DomainException
     */
    #[Route(path: '/api/question/{questionId}', name: 'api-delete-question', methods: ['DELETE'])]
    #[IsGranted(User::ROLE_USER)]
    public function handle(string $questionId): Response
    {
        $command = $this->decodeTo(RemoveQuestionCommand::class);
        $question = $this->handler->handle($command);
        return $this->apiResponse(
            $question,
            Response::HTTP_NO_CONTENT
        );
    }
}
