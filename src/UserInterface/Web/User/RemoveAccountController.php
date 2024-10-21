<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Web\User;

use App\Application\User\RemoveUserAccountCommand;
use App\Application\User\RemoveUserAccountHandler;
use App\Domain\DomainException;
use App\Domain\User\UserId;
use App\Domain\User\UserRepository;
use App\UserInterface\Web\User\Form\RemoveUserAccountType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * RemoveAccountController
 *
 * @package App\UserInterface\Web\User
 */
final class RemoveAccountController extends AbstractController
{

    public function __construct(
        private readonly UserRepository $users,
        private readonly RemoveUserAccountHandler $handler,
        private readonly TranslatorInterface $translator,
        private readonly Security $security
    ) {
    }


    /**
     * This method handles the removal of a user account based on the provided user ID.
     *
     * @Route(path="/user/profile/{userId}/remove-account", name="remove-account")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     *
     * @param Request $request The request object
     * @param ?string $userId The optional user ID
     * @return Response The response object
     * @throws DomainException
     */
    #[Route(path: "/user/profile/{userId}/remove-account", name:'remove-account')]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function handle(Request $request, ?string $userId = null): Response
    {
        $user = null == $userId ? $this->users->currentLoggedInUser() : $this->users->withId(new UserId($userId));
        $active = "remove";
        $form = $this->createForm(RemoveUserAccountType::class, new RemoveUserAccountCommand($user->userId()));

        try {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                return $this->processUserRemove($form->getData());
            }
        } catch (Exception $exception) {
            $this->addFlash('danger', $exception->getMessage());
        }

        return $this->render("user/remove-account.html.twig", compact("user", "active", "form"));
    }

    /**
     * @throws DomainException
     */
    private function processUserRemove(RemoveUserAccountCommand $command): Response
    {
        $user = $this->handler->handle($command);
        $this->security->logout(false);
        $this->addFlash(
            'success',
            $this->translator->trans(
                "%name%, your account has been successfully deleted. We're sorry to see you go, but you're always welcome to return ".
                "and create a new account in the future. Thank you for being a part of our community!",
                ["%name%" => $user->name()]
            )
        );
        return $this->redirectToRoute('homepage');
    }
}
