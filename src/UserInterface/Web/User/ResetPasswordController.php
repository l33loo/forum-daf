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
use App\Application\User\ChangeUserPasswordCommand;
use App\Application\User\ChangeUserPasswordHandler;
use App\Application\User\RequestPasswordResetCommand;
use App\Application\User\RequestPasswordResetHandler;
use App\Domain\User;
use App\UserInterface\Web\User\Form\ResetPasswordRequestType;
use App\UserInterface\Web\User\Form\ResetPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

/**
 * ResetPasswordController
 *
 * @package App\UserInterface\Web\User
 */
final class ResetPasswordController extends AbstractController
{

    public function __construct(
        private readonly RequestPasswordResetHandler $handler,
        private readonly ChangeUserPasswordHandler $changeUserPasswordHandler,
        private readonly ResetPasswordHelperInterface $resetPasswordHelper,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/user/reset-password', name: 'reset-password')]
    public function resetPassword(Request $request): Response
    {
        $token = $request->query->get('token');

        try {
            /** @var User $user */
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
            $form = $this->createForm(ResetPasswordType::class, new ChangeUserPasswordCommand($user->userId(), ''));
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                return $this->processChangePassword($form);
            }
        } catch (ResetPasswordExceptionInterface $exception) {
            $this->addFlash('danger', $exception->getReason());
        } catch (AppException $exception) {
            $this->addFlash('danger', $exception->getMessage());
        } finally {
            if (!isset($user)) {
                return $this->redirectToRoute('reset-password-request');
            }
        }

        return $this->render('user/reset-password/change.html.twig', ['user' => $user ?? null, 'form' => $form ?? null]);
    }

    #[Route('/user/reset-password-request', name: 'reset-password-request')]
    public function request(Request $request): Response
    {
        $form = $this->createForm(ResetPasswordRequestType::class);
        try {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
               $this->processRequestForm($form);
            }
        } catch (AppException $exception) {
            $form->addError(new FormError($exception->getMessage()));
        } catch (ResetPasswordExceptionInterface $exception) {
            $this->addFlash('danger', $exception->getReason());
        }
        return $this->render('user/reset-password/request.html.twig', compact('form'));
    }

    private function processRequestForm(FormInterface $form): void
    {
        /** @var RequestPasswordResetCommand $command */
        $command = $form->getData();
        $this->handler->handle($command);
        $this->addFlash('success', $this->translator->trans('If there is a user with the provided email address, a link to reset your password will be sent to you.'));
    }

    private function processChangePassword(FormInterface $form): Response
    {
        /**  @param ChangeUserPasswordCommand $command */
        $command = $form->getData();
        $user = $this->changeUserPasswordHandler->handle($command);
        $this->addFlash('success', $this->translator->trans('{name}, your password was successfully changed.', ['name' => $user->name()]));
        return $this->redirectToRoute('login');
    }
}
