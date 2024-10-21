<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Console\User;

use App\Application\User\PromoteUserToAdminCommand;
use App\Application\User\PromoteUserToAdminHandler;
use App\Domain\User\Email;
use App\Domain\User\UserRepository;
use App\UserInterface\Exception\InvalidInput;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * PromoteUser
 *
 * @package App\UserInterface\Console\User
 */
#[AsCommand(name: 'app:user:promote', description: 'Promote user to admin role', aliases: ["promote"])]
final class PromoteUser extends Command
{

    private SymfonyStyle $style;

    private Email $email;

    public function __construct(
        private readonly UserRepository $users,
        private readonly PromoteUserToAdminHandler $handler
    ) {
        parent::__construct();
    }


    protected function configure(): void
    {
        $this
            ->addArgument(name: 'email', description: "User's email address")
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->style = new SymfonyStyle($input, $output);
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $this->checkEmail($input);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $user = $this->users->withEmail($this->email);
            $this->handler->handle(new PromoteUserToAdminCommand($user->userId()));

            $this->style->success("User {$user->name()} successfully promoted to admin role.");

            return Command::SUCCESS;

        } catch (\Exception $exception) {
            $this->style->error($exception->getMessage());
        }
        return Command::FAILURE;
    }

    private function checkEmail(InputInterface $input): void
    {
        $argumentEmail = $input->getArgument('email');
        if ($argumentEmail) {
            $this->email = new Email($argumentEmail);
            return;
        }

        $this->email = $this->style->ask(
            question: "User email address",
            validator: function ($answer) {
                if (!is_string($answer) || strlen($answer) <= 0) {
                    throw new InvalidInput(
                        "User email cannot be null."
                    );
                }

                return new Email($answer);
            }
        );
    }
}
