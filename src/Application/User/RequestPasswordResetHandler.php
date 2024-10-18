<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\DomainException;
use App\Domain\Event\User\PasswordResetWasRequested;
use App\Domain\Exception\EntityNotFound;
use App\Domain\User;
use App\Domain\User\UserRepository;
use Slick\Event\EventDispatcher;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

/**
 * RequestPasswordResetHandler
 *
 * @package App\Application\User
 */
final readonly class RequestPasswordResetHandler
{


    public function __construct(
        private UserRepository $users,
        private ResetPasswordHelperInterface $helper,
        private EventDispatcher $dispatcher
    ) {
    }

    /**
     * @throws DomainException|EntityNotFound
     */
    public function handle(RequestPasswordResetCommand $command): User
    {
        $user = $this->users->withEmail($command->email());
        $token = $this->helper->generateResetToken($user);
        $this->dispatcher->dispatch(new PasswordResetWasRequested($user->userId(), $token->getToken()));
        return $user;
    }


}
