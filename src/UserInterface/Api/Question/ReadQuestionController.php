<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\Question;

use App\Domain\DomainException;
use App\Domain\Question\QuestionId;
use App\Domain\Question\QuestionRepository;
use App\Domain\User;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * ReadQuestionController
 *
 * @package App\UserInterface\Api\Question
 */
final class ReadQuestionController extends AbstractController
{
    use ApiControllerMethods;

    /**
     * @throws DomainException
     */
    #[Route('/api/question/{questionId}', name: 'api-read-question')]
    #[IsGranted(User::ROLE_USER)]
    public function read(string $questionId, QuestionRepository $questions): Response
    {
        $questionId = new QuestionId($questionId);
        $question = $questions->withId($questionId);
        return $this->apiResponse($question);
    }
}
