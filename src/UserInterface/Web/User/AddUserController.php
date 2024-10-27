<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Web\User;

use App\Application\User\ChangeUserPasswordCommand;
use App\Application\User\ChangeUserPasswordHandler;
use App\Application\User\CreateUserCommand;
use App\Application\User\CreateUserHandler;
use App\UserInterface\Web\User\Form\CreateUserType;
use SensitiveParameter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * AddUserController
 *
 * @package App\UserInterface\Web\User
 */
final class AddUserController extends AbstractController
{

    public function __construct(
        private readonly CreateUserHandler $handler,
        private readonly ChangeUserPasswordHandler $passwordHandler,
        private readonly TranslatorInterface $translator
    ) {

    }

    #[Route('/user/add', name: 'add-user')]
    public function handler(Request $request): Response
    {
        $form = $this->createForm(CreateUserType::class);
        try {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                list($command, $password) = array_values($form->getData());
                return $this->saveUserAndChangePassword($command, $password);
            }
        } catch (\Exception $exception) {
            $this->addFlash('danger', $exception->getMessage());
        }

        return $this->render('user/add-user.html.twig', compact('form'));
    }

    private function saveUserAndChangePassword(CreateUserCommand $command, #[SensitiveParameter] string $password): Response
    {
        $user = $this->handler->handle($command);
        $this->passwordHandler->handle(new ChangeUserPasswordCommand($user->userId(), $password));
        $this->addFlash('success', $this->translator->trans('User was successfully added.'));
        return $this->redirectToRoute('user-profile', ['userId' => $user->userId()]);
    }
}
