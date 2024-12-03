<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\Question;

use App\Application\Question\GiveAnswerCommand;
use App\Application\Question\GiveAnswerHandler;
use App\Domain\DomainException;
use App\Domain\User;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * GiveAnswerController
 *
 * @package App\UserInterface\Api\Answer
 */
final class GiveAnswerController extends AbstractController
{
    use ApiControllerMethods;

    /**
     * @throws DomainException
     */
    #[Route(path: '/api/answer', name: 'api-post-answer', methods: ['POST'])]
    #[IsGranted(User::ROLE_USER)]
    public function handle(GiveAnswerHandler $handler): Response
    {
        $command = $this->decodeTo(GiveAnswerCommand::class);
        $answer = $handler->handle($command);
        return $this->apiResponse(
            $answer,
            Response::HTTP_CREATED,
            [
                "location" => $this->generateUrl('api-read-answer', ['answerId' => $answer->answerId()])
            ]
        );
    }
}
