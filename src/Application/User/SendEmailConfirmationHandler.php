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
use App\Domain\DomainException;
use App\Domain\Event\User\EmailConfirmationWasSent;
use App\Domain\User\Email\EmailConfirmationMessage;
use App\Domain\User\UserRepository;
use Slick\Event\EventDispatcher;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * SendEmailConfirmationHandler
 *
 * @package App\Application\User
 */
final readonly class SendEmailConfirmationHandler
{


    public function __construct(
        private UserRepository $users,
        private EmailContentCreator $contentCreator,
        private TranslatorInterface $translator,
        private EmailSender $emailSender,
        private EventDispatcher $dispatcher
    ) {
    }

    /**
     * Handles sending an email confirmation message after registration.
     *
     * @param SendEmailConfirmationCommand $command The command containing necessary data
     * @return EmailConfirmationMessage The email confirmation message sent
     * @throws DomainException
     */
    public function handle(
        SendEmailConfirmationCommand|SendUpdateEmailConfirmationCommand $command
    ): EmailConfirmationMessage {
        $user = $this->users->withId($command->userId());
        $subject = $this->translator->trans("Confirm Your Email Address - Forum DAF");
        $content = $this->contentCreator->createContentFor(
            EmailConfirmationMessage::class,
            compact('user', 'subject')
        );

        $message = $command instanceof SendUpdateEmailConfirmationCommand
            ? EmailConfirmationMessage::createFromUpdate($user, $subject, $content)
            : new EmailConfirmationMessage($user, $subject, $content);

        $this->emailSender->sendEmail($message);
        $this->dispatcher->dispatchEventsFrom($user);
        $this->dispatcher->dispatch(
            new EmailConfirmationWasSent($command->userId(), $message->messageId(), $message->message())
        );
        return $message;
    }


}
