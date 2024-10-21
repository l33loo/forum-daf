<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Web\User;

use App\Application\User\ConfirmUserEmailCommand;
use App\Application\User\ConfirmUserEmailHandler;
use App\Domain\DomainException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * ConfirmEmailController
 *
 * @package App\UserInterface\Web\User
 */
final class ConfirmEmailController extends AbstractController
{
    public function __construct(
        private readonly ConfirmUserEmailHandler $handler,
        private readonly TranslatorInterface $translator
    ) {
    }

    #[Route('/confirm-email', name: 'confirm-email')]
    #[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
    public function handle(Request $request, Security $security): Response
    {
        $token = $request->query->get('token');
        try {
            $user = $this->handler->handle(new ConfirmUserEmailCommand($token));
            $security->logout(false);
            $security->login($user, 'form_login');
            $this->addFlash("success", $this->translator->trans(
                "Thank you %name%! Your email address has been confirmed. Your account details are now completed.",
                ["%name%" => $user->name()]
            ));
        } catch (DomainException $exception) {
            $this->addFlash("danger", $exception->getMessage());
            return $this->redirectToRoute('homepage');
        }

        return $this->redirectToRoute('user-profile', ['userId' => $user->userId()]);
    }
}
