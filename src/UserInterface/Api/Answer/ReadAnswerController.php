<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\Answer;

use App\Domain\DomainException;
use App\Domain\Answer\AnswerId;
use App\Domain\Answer\AnswerRepository;
use App\Domain\User;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * ReadAnswerController
 *
 * @package App\UserInterface\Api\Answer
 */
final class ReadAnswerController extends AbstractController
{
    use ApiControllerMethods;

    /**
     * @throws DomainException
     */
    #[Route('/api/answer/{answerId}', name: 'api-read-answer')]
    #[IsGranted(User::ROLE_USER)]
    public function read(string $answerId, AnswerRepository $answers): Response
    {
        $answerId = new AnswerId($answerId);
        $answer = $answers->withId($answerId);
        return $this->apiResponse($answer);
    }
}
