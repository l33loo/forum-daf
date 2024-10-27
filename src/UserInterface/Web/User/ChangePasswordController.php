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
use App\Domain\DomainException;
use App\Domain\User;
use App\Domain\User\UserId;
use App\Domain\User\UserRepository;
use App\UserInterface\Web\User\Form\ChangePasswordType;
use Exception;
use SensitiveParameter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * ChangePasswordController
 *
 * @package App\UserInterface\Web\User
 */
final class ChangePasswordController extends AbstractController
{

    use UserAwareControllerTrait;

    public function __construct(
        private readonly ChangeUserPasswordHandler $handler,
        private readonly UserRepository $users,
        private readonly UserPasswordHasherInterface $hasher,
        private readonly TranslatorInterface $translator
    ) {
    }

    /**
     * @throws DomainException
     */
    #[Route(path: "user/profile/{userId}/change-password", name: 'change-password')]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function handle(Request $request, Security $security, ?string $userId = null): Response
    {
        $user = $this->userFrom($security, $userId);
        $form = $this->createForm(ChangePasswordType::class, new ChangeUserPasswordCommand($user->userId(), ''));
        try {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user = $this->processChangePassword($form->getData(), $form->get('oldPassword')->getData(), $user);
                if ($this->isGranted(User::ROLE_ADMIN)) {
                    return $this->redirectToRoute('users');
                }
            }
        } catch (Exception $exception) {
            $this->addFlash('danger', $exception->getMessage());
        }

        return $this->render('user/change-password.html.twig', ['user' => $user, 'active' => 'password', 'form' => $form]);
    }

    private function processChangePassword(
        ChangeUserPasswordCommand $command,
        #[SensitiveParameter]
        ?string $oldPassword,
        User $user
    ): User {
        $valid = $this->isGranted(User::ROLE_ADMIN) || $this->hasher->isPasswordValid($user, $oldPassword);
        if (!$valid) {
            $this->addFlash("danger", $this->translator->trans("Your current password is incorrect."));
            return $user;
        }

        $user = $this->handler->handle($command);
        $this->addFlash("success", $this->translator->trans("Password has been changed successfully."));
        return $user;
    }
}
