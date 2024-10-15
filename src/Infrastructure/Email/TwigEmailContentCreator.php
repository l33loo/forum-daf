<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Email;

use App\Domain\Common\EmailMessage\EmailContentCreator;
use App\Domain\Common\EmailMessage\MessageContent;
use App\Domain\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * TwigEmailContentCreator
 *
 * @package App\Infrastructure\Email
 */
final readonly class TwigEmailContentCreator implements EmailContentCreator
{

    /**
     * Creates a TwigEmailContentCreator
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(private TranslatorInterface $translator)
    {
    }

    /**
     * @inheritDoc
     */
    public function createContentFor(string $className, ?array $context = []): MessageContent
    {
        $lang = $this->translator->getLocale();
        $htmlFilename = "{$this->parseName($className)}.html.twig";
        $txtFilename = "{$this->parseName($className)}.txt.twig";
        $htmlContent = "emails/$lang/$htmlFilename";
        $txtContent = "emails/$lang/$txtFilename";
        $fileExists = file_exists(dirname(__DIR__, 3).'/templates/'.$txtContent);


        return new MessageContent(
            $htmlContent,
            $fileExists ? $txtContent : null
        );
    }

    /**
     * Converts a camel case string to snake case by adding dashes before uppercase
     * characters and converting to lowercase.
     *
     * @param string $camelCase The camel case string to convert to snake case
     * @return string The resulting string in snake case
     */
    public function camelToSnake(string $camelCase): string
    {
        $result = '';

        for ($i = 0; $i < strlen($camelCase); $i++) {
            $char = $camelCase[$i];
            $result .= ctype_upper($char) ? '-' . strtolower($char) : $char;
        }

        return ltrim($result, '-');
    }

    /**
     * Parses a fully qualified class name to get the last part after backslashes,
     * then converts it from camel case to snake case.
     *
     * @param string $className The fully qualified class name to parse
     * @return string The last part of the class name in snake case
     */
    private function parseName(string $className): string
    {
        $parts = explode('\\', $className);
        $name = array_pop($parts);
        return $this->camelToSnake($name);
    }
}
