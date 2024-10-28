<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Events;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Translation\LocaleSwitcher;

/**
 * LanguageSwitcherListener
 *
 * @package App\Infrastructure\Events
 */
#[AsEventListener(event: 'kernel.controller', method: 'onController')]
#[AsEventListener(event: 'kernel.response', method: 'onResponse')]
final class LanguageSwitcherListener
{

    private static ?string $locale = null;

    public function __construct(
        private LocaleSwitcher $localeSwitcher,
    ) {
    }

    public function onController(ControllerEvent $event): void
    {
        $request = $event->getRequest();

        if (str_starts_with($request->getPathInfo(), "/_")) {
            return;
        }

        $current = $this->localeSwitcher->getLocale();
        $fallback = $request->getPreferredLanguage(['en', 'pt']);
        $cookie = $request->cookies->get('locale', $fallback);
        $locale = $request->query->get('lang', $cookie);

        if ($current !== $locale || $cookie !== $locale) {
            $this->localeSwitcher->setLocale($locale);
            self::$locale = $locale;
        }
    }

    public function onResponse(ResponseEvent $event): void
    {

        if (self::$locale) {
            $event->getResponse()->headers->setCookie(new Cookie('locale', self::$locale));
        }
    }

}
