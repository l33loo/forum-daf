<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Console\User;

use App\Application\User\ChangeUserPasswordCommand;
use App\Application\User\ChangeUserPasswordHandler;
use App\Application\User\CreateUserCommand;
use App\Application\User\CreateUserHandler;
use App\Domain\User\Email;
use App\UserInterface\Exception\InvalidInput;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

/**
 * CreateUser
 *
 * @package App\UserInterface\Console\User
 */
#[AsCommand(
    name: 'app:user:create',
    description: 'Creates a new user account.',
    aliases: ['useradd'],
)]
final class CreateUser extends Command
{

    private Email $email;
    private ?string $name = null;
    private ?string $password = null;
    private SymfonyStyle $style;

    private bool $noPassword = false;

    public function __construct(
        private readonly CreateUserHandler $createHandler,
        private readonly ChangeUserPasswordHandler $changePasswordHandler
    ) {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this
            ->addArgument(name: 'email', description: "User's email address")
            ->addArgument(name: 'name', mode: InputArgument::OPTIONAL, description: "Username")
            ->addArgument(
                name: 'password',
                mode: InputArgument::OPTIONAL,
                description: "Password for authentication processes"
            )
            ->addOption(
                name: "no-password",
                shortcut: "o",
                mode: InputOption::VALUE_NONE,
                description: "Do not ask for password"
            )
        ;
    }

    /**
     * @inheritDoc
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->style = new SymfonyStyle($input, $output);
    }

    /**
     * @inheritDoc
     */
    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $this->noPassword = (bool) $input->getOption('no-password');
        $this->checkEmail($input);
        $this->checkPassword($input);
        $this->checkName($input);
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $user = $this->createHandler->handle(
                new CreateUserCommand($this->email, $this->name)
            );

            if ($this->password) {
                $this->changePasswordHandler->handle(
                    new ChangeUserPasswordCommand($user->userId(), $this->password)
                );
            }

            $this->style->success("User {$user->name()} successfully created.");

            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->style->error($e->getMessage());
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

    private function checkPassword(InputInterface $input): void
    {
        if ($this->noPassword) {
            return;
        }

        $argumentPassword = $input->getArgument('password');
        if ($argumentPassword) {
            $this->password = $argumentPassword;
            return;
        }

        $this->password = $this->style->askHidden(
            question: "Password",
            validator: function ($answer) {
                if (!is_string($answer) || strlen($answer) < 8) {
                    throw new InvalidInput(
                        "Password must have at least 8 characters long"
                    );
                }

                return $answer;
            }
        );
    }

    private function checkName(InputInterface $input): void
    {
        $argumentName = $input->getArgument('name');
        if ($argumentName) {
            $this->name = $argumentName;
            return;
        }

        $this->name = $this->style->ask(
            question: "User name",
            validator: function ($answer) {
                if (!is_string($answer) || strlen($answer) <= 0) {
                    return null;
                }

                return $answer;
            }
        );
    }
}
