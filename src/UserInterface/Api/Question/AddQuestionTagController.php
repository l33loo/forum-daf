<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\Question;

use App\Application\Question\AddQuestionTagCommand;
use App\Application\Question\AddQuestionTagHandler;
use App\Application\User\ChangeUserPasswordHandler;
use App\Domain\DomainException;
use App\Domain\Question\QuestionId;
use App\Domain\User;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * AddQuestionTagController
 *
 * @package App\UserInterface\Api\Question
 */
final class AddQuestionTagController extends AbstractController
{
    use ApiControllerMethods;

    public function __construct(private readonly AddQuestionTagHandler $handler)
    {}

    /**
     * @throws DomainException
     */
    #[Route(path: '/api/question/{questionId}', name: 'api-add-question-tag', methods: ['PATCH'])]
    #[IsGranted(User::ROLE_USER)]
    public function handle(QuestionId $questionId, string $tag): Response
    {
        $command = $this->decodeTo(AddQuestionTagCommand::class);
        $question = $this->handler->handle($command);
        return $this->apiResponse(
            $question,
            Response::HTTP_ACCEPTED,
            [
                "location" => $this->generateUrl('api-read-question', ['questionId' => $question->question()])
            ]
        );
    }
}
