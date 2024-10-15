<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Common\EmailMessage;

use App\Domain\Common\EmailMessage;

/**
 * EmailSender
 *
 * @package App\Domain\Common\EmailMessage
 */
interface EmailSender
{

    /**
     * Sends an email using the provided EmailMessage object.
     *
     * @param EmailMessage $message The email message object to send
     * @return EmailMessage The sent email message object
     */
    public function sendEmail(EmailMessage $message): EmailMessage;
}
