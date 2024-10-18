<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\Common\EmailMessage\EmailContentCreator;
use App\Domain\Common\EmailMessage\EmailSender;
use App\Domain\Event\User\ResetPasswordEmailWasSent;
use App\Domain\User\Email\ResetPasswordMessage;
use App\Domain\User\UserRepository;
use Slick\Event\EventDispatcher;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * SendPasswordResetEmailHandler
 *
 * @package App\Application\User
 */
final readonly class SendPasswordResetEmailHandler
{


    /**
     * Creates a SendPasswordResetEmailHandler
     *
     * @param UserRepository $users
     * @param EmailContentCreator $contentCreator
     * @param TranslatorInterface $translator
     * @param EmailSender $emailSender
     * @param EventDispatcher $dispatcher
     */
    public function __construct(
        private UserRepository $users,
        private EmailContentCreator $contentCreator,
        private TranslatorInterface $translator,
        private EmailSender $emailSender,
        private EventDispatcher $dispatcher
    ) {
    }

    public function handle(SendPasswordResetEmailCommand $command): ResetPasswordMessage
    {
        $user = $this->users->withId($command->userId());
        $subject = $this->translator->trans('Reset Your Password - Forum DAF');
        $content = $this->contentCreator->createContentFor(ResetPasswordMessage::class, [
            'user' => $user,
            'subject' => $subject,
            'token' => $command->token(),
        ]);
        $message = new ResetPasswordMessage($user, $command->token(), $subject, $content);
        $this->emailSender->sendEmail($message);
        $this->dispatcher->dispatch(
            new ResetPasswordEmailWasSent($user->userId(), $message->messageId(), $content)
        );

        return $message;
    }


}
