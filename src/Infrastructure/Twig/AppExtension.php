<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Twig;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * AppExtension
 *
 * @package App\Infrastructure\Twig
 */
final class AppExtension extends AbstractExtension
{

    /**
     * Creates a AppExtension
     *
     * @param Request $request
     */
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('route_is', [$this, 'routeIs']),
            new TwigFunction('path_starts_with', [$this, 'pathStartsWith']),
        ];
    }

    /**
     * @param string $route
     * @return bool
     */
    public function routeIs(string $route): bool
    {
        $routeName = $this->requestStack->getCurrentRequest()->attributes->get('_route');
        return $routeName === $route;
    }

    /**
     * Checks if the path of the request starts with a specific string.
     *
     * @param string $needle The string to check if the path starts with.
     * @return bool Returns true if the path starts with the provided string, false otherwise.
     */
    public function pathStartsWith(string $needle): bool
    {
        $path = $this->requestStack->getCurrentRequest()->getPathInfo();
        return str_starts_with($path, $needle);
    }


}
