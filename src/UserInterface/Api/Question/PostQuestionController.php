<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\Question;

use App\Application\Question\PostQuestionCommand;
use App\Application\Question\PostQuestionHandler;
use App\Domain\DomainException;
use App\Domain\User;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * PostQuestionController
 *
 * @package App\UserInterface\Api\Question
 */
final class PostQuestionController extends AbstractController
{
    use ApiControllerMethods;

    /**
     * @throws DomainException
     */
    #[Route(path: '/api/question', name: 'api-post-question', methods: ['POST'])]
    #[IsGranted(User::ROLE_USER)]
    public function handle(PostQuestionHandler $handler): Response
    {
        $command = $this->decodeTo(PostQuestionCommand::class);
        $question = $handler->handle($command);
        return $this->apiResponse(
            $question,
            Response::HTTP_CREATED,
            [
                "location" => $this->generateUrl('api-read-question', ['questionId' => $question->question()])
            ]
        );
    }
}
