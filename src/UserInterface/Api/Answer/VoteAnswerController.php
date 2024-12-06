<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\Answer;

use App\Application\Answer\VoteAnswerCommand;
use App\Application\Answer\VoteAnswerHandler;
use App\Domain\DomainException;
use App\Domain\Answer\AnswerId;
use App\Domain\User;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * VoteAnswerController
 *
 * @package App\UserInterface\Api\Answer
 */
final class VoteAnswerController extends AbstractController
{
    use ApiControllerMethods;

    public function __construct(private readonly VoteAnswerHandler $handler)
    {}

    /**
     * @throws DomainException
     */
    #[Route(path: '/api/answer/{answerId}/add-vote', name: 'api-vote-answer', methods: ['PATCH'])]
    #[IsGranted(User::ROLE_USER)]
    public function handle(string $answerId): Response
    {
        $command = $this->decodeTo(VoteAnswerCommand::class);
        $answer = $this->handler->handle($command);
        return $this->apiResponse(
            $answer,
            Response::HTTP_OK,
            [
                "location" => $this->generateUrl('api-read-answer', ['answerId' => $answer->answerId()])
            ]
        );
    }
}
