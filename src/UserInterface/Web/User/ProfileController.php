<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Web\User;

use App\Application\User\SendEmailConfirmationHandler;
use App\Application\User\SendUpdateEmailConfirmationCommand;
use App\Application\User\UpdateUserCommand;
use App\Application\User\UpdateUserHandler;
use App\Domain\DomainException;
use App\Domain\Exception\FailedSpecification;
use App\Domain\User;
use App\Domain\User\UserId;
use App\Domain\User\UserRepository;
use App\UserInterface\Web\User\Form\UpdateUserType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * ProfileController
 *
 * @package App\UserInterface\Web\User
 */
final class ProfileController extends AbstractController
{

    public function __construct(
        private readonly UserRepository $users,
        private readonly UpdateUserHandler $handler,
        private readonly TranslatorInterface $translator
    ) {
    }

    /**
     * @throws DomainException
     */
    #[Route(path: "/user/profile/{userId}", name:'user-profile')]
    #[IsGranted("IS_AUTHENTICATED_REMEMBERED")]
    public function handle(Request $request, Security $security, ?string $userId = null): Response
    {
        $user = null == $userId ? $this->users->currentLoggedInUser() : $this->users->withId(new UserId($userId));
        $command = new UpdateUserCommand($user->userId(), $user->name(), $user->email());
        $form = $this->createForm(UpdateUserType::class, $command);

        try {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user = $this->processUserUpdate($form->getData(), $security);
            }
        } catch (FailedSpecification) {
            $this->addFlash('danger', $this->translator->trans(
                "The email address '%email%' is already taken by other user. ".
                "Please try a different email address.",
                ['%email%' => $form->getData()->email()]
            ));
        } catch (Exception $exception) {
            $this->addFlash('danger', $exception->getMessage());
        }

        return $this->render('user/profile.html.twig', compact("user", "form"));
    }

    private function processUserUpdate(UpdateUserCommand $command, Security $security): User
    {
        $user = $this->handler->handle($command);
        $this->addFlash('success', $this->translator->trans('User details were successfully updated!'));

        if (!$user->email()->equals($security->getUser()->email())) {
            $security->login($user, 'form_login');
        }
        return $user;
    }

    #[Route(path: "/user/profile/{userId}/resend-email-link", name:'resend-email-link')]
    #[IsGranted("IS_AUTHENTICATED_REMEMBERED")]
    public function resendConfirmationEmail(SendEmailConfirmationHandler $handler, ?string $userId = null): Response
    {
        $user = null == $userId ? $this->users->currentLoggedInUser() : $this->users->withId(new UserId($userId));
        $command = new SendUpdateEmailConfirmationCommand($user->userId());
        $handler->handle($command);
        $this->addFlash(
            'success',
            $this->translator->trans(
                "A new verification email has been sent to your inbox. ".
                "Please check your email to complete the verification process."
            )
        );

        return $this->redirectToRoute("user-profile", ['userId' => $user->userId()]);
    }
}
