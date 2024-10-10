<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Console;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;

/**
 * ConsoleTerminateEventListener
 *
 * @package App\UserInterface\Console
 */
final class ConsoleTerminateEventListener
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {

    }

    public function onTerminate()
    {
        $this->entityManager->flush();
    }
}
