<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Events;

use App\Domain\Exception\EntityNotFound;
use App\Domain\Exception\FailedSpecification;
use Slick\JSONAPI\Document\DocumentEncoder;
use Slick\JSONAPI\Document\ErrorDocument;
use Slick\JSONAPI\Object\ErrorObject;
use Slick\JSONAPI\Object\ResourceCollection;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * ApiExceptionListener
 *
 * @package App\Infrastructure\Events
 */
#[AsEventListener(event: "kernel.exception", method: "onKernelException")]
final class ApiExceptionListener
{

    private static array $map = [
        NotFoundHttpException::class => 404,
        EntityNotFound::class => 404,
        FailedSpecification::class => 400
    ];

    public function __construct(private readonly DocumentEncoder $encoder)
    {
    }


    public function onKernelException(ExceptionEvent $event): void
    {
        $path = $event->getRequest()->getPathInfo();
        if (!str_starts_with($path, '/api/')) {
            return;
        }

        $exception = $event->getThrowable();
        $exceptionType = get_class($exception);
        $statusCode = array_key_exists($exceptionType, self::$map) ? self::$map[$exceptionType] : Response::HTTP_INTERNAL_SERVER_ERROR;
        $parts = explode('\\', $exceptionType);
        $title = array_pop($parts);

        $error = new ErrorDocument(new ResourceCollection('errors', [
            new ErrorObject(title: $title, detail: $exception->getMessage(), status: (string) $statusCode ?? "500"),
        ]));

        $event->setResponse(new Response($this->encoder->encode($error), $statusCode ?? 500, ['Content-Type' => 'application/vnd.api+json']));
        $event->stopPropagation();
    }
}
