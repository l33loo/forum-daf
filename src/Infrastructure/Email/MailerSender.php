<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Email;

use App\Domain\Common\EmailMessage;
use App\Domain\Common\EmailMessage\EmailSender;
use App\Domain\User;
use App\Domain\User\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email as MimeEmail;

/**
 * MailerSender
 *
 * @package App\Infrastructure\Email
 */
final readonly class MailerSender implements EmailSender
{

    public function __construct(private MailerInterface $mailer)
    {

    }

    /**
     * @inheritDoc
     */
    public function sendEmail(EmailMessage $message): EmailMessage
    {
        $recipients = $this->fixRecipients($message->recipients());
        $email = (new TemplatedEmail())
            ->from(new Address('example@example.com', 'Forum DAF'))
            ->to(...$recipients)
            ->subject($message->subject())
            ->htmlTemplate($message->message()->primaryContent())
            ->textTemplate($message->message()->alternativeContent())
            ->context($message->context());
        $this->mailer->send($email);
        return $message;
    }

    /**
     * @param array<User|Email> $recipients
     * @return array<Address|string>
     */
    private function fixRecipients(array $recipients): array
    {
        $result = [];
        foreach ($recipients as $recipient) {
            if ($recipient instanceof Email) {
                $result[] = (string) $recipient;
                continue;
            }

            $result[] = new Address((string) $recipient->email(), $recipient->name());
        }
        return $result;
    }
}
