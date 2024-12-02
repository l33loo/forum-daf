<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\Answer;

use App\Application\Answer\DeleteAnswerCommand;
use App\Application\Answer\DeleteAnswerHandler;
use App\Domain\DomainException;
use App\Domain\Answer\AnswerId;
use App\Domain\User;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * DeleteAnswerController
 *
 * @package App\UserInterface\Api\Answer
 */
final class DeleteAnswerController extends AbstractController
{
    use ApiControllerMethods;

    public function __construct(private readonly DeleteAnswerHandler $handler)
    {}

    /**
     * @throws DomainException
     */
    #[Route(path: '/api/answer/{answerId}', name: 'api-delete-answer', methods: ['DELETE'])]
    #[IsGranted(User::ROLE_USER)]
    public function handle(AnswerId $answerId): Response
    {
        $command = $this->decodeTo(DeleteAnswerCommand::class);
        $answer = $this->handler->handle($command);
        return $this->apiResponse(
            $answer,
            Response::HTTP_NO_CONTENT,
            [
                // TODO: fix this
                "location" => $this->generateUrl('api-read-answer', ['answerId' => $answer->answerId()])
            ]
        );
    }
}
