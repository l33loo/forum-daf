<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Web\User;

use App\Application\User\BanUserCommand;
use App\Application\User\BanUserHandler;
use App\Domain\User;
use App\Domain\User\UserId;
use App\Domain\User\UserRepository;
use App\UserInterface\Web\User\Form\BanUserType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * BanController
 *
 * @package App\UserInterface\Web\User
 */
final class BanController extends AbstractController
{

    public function __construct(
        private readonly UserRepository $users,
        private readonly BanUserHandler $handler
    ) {
    }

    #[Route('/user/profile/{userId}/ban', name: 'ban')]
    #[IsGranted(User::ROLE_ADMIN)]
    public function handle(Request $request, ?string $userId = null): Response
    {
        $user = $this->users->withId(new UserId($userId));
        $form = $this->createForm(BanUserType::class, new BanUserCommand($user->userId(), ''));
        $active = "ban";
        try {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                return $this->banUser($form->getData());
            }
        } catch (Exception $exception) {
            $this->addFlash('danger', $exception->getMessage());
        }
        return $this->render('user/ban.html.twig', compact('user', 'form', 'active'));
    }

    private function banUser(BanUserCommand $command): Response
    {
        $this->handler->handle($command);
        $this->addFlash(
            'success',
            "User successfully banned. The next time they log in, the reason for the ban will be displayed, ".
            "and they will no longer have access to the site.");
        return $this->redirectToRoute('homepage');
    }
}
