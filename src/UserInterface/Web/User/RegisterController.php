<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Web\User;

use App\AppException;
use App\Application\User\RegisterUserCommand;
use App\Application\User\RegisterUserHandler;
use App\UserInterface\Web\User\Form\RegisterUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * RegisterController
 *
 * @package App\UserInterface\Web\User
 */
final class RegisterController extends AbstractController
{

    public function __construct(
        private readonly RegisterUserHandler $registerUserHandler,
        private readonly Security $security,
        private readonly TranslatorInterface $translator
    ) {

    }

    #[Route('/user/register', name: 'register')]
    public function register(Request $request): Response
    {
        $form = $this->createForm(RegisterUserType::class);

        try {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                return $this->processForm($form);
            }
        } catch (AppException $exception) {
            $form->addError(new FormError($exception->getMessage()));
        }

        return $this->render('user/register.html.twig', compact(['form']));
    }

    private function processForm(FormInterface $form): Response
    {
        /** @var RegisterUserCommand $command */
        $command = $form->getData();
        $user = $this->registerUserHandler->handle($command);
        $this->security->login($user, 'form_login');

        $this->addFlash(
            'success',
            $this->translator->trans('Welcome a board {name}! You have been registered.', ['name' => $user->name()])
        );

        return $this->redirectToRoute('homepage');
    }
}
