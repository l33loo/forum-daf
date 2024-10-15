<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Console\User;

use App\Application\User\SendEmailConfirmationCommand;
use App\Application\User\SendEmailConfirmationHandler;
use App\Domain\User\Email;
use App\Domain\User\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * SendEmailConfirmation
 *
 * @package App\UserInterface\Console\User
 */
#[AsCommand(name: 'app:send-email-confirmation', description: 'Send email confirmation')]
final class SendEmailConfirmation extends Command
{
    public function __construct(private UserRepository $users, private SendEmailConfirmationHandler $confirmationHandler)
    {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->users->withEmail(new Email("silvam.filipe@gmail.com"));
        $command = new SendEmailConfirmationCommand($user->userId());
        $this->confirmationHandler->handle($command);
        return self::SUCCESS;
    }


}
