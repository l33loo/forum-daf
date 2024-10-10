<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

/**
 * DoctrineResponseEventListener
 *
 * @package App\Infrastructure\Doctrine
 */
final class DoctrineResponseEventListener
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function onResponse(ResponseEvent $event): void
    {
        $statusCode = $event->getResponse()->getStatusCode();
        $successResponse = $statusCode >= 200 && $statusCode < 400;

        if ($successResponse) {
            $this->entityManager->flush();
        }
    }
}
