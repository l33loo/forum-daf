<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Groq;

use App\Domain\ContentValidator;
use LucianoTonet\GroqPHP\Groq;
use LucianoTonet\GroqPHP\GroqException;

/**
 * GroqContentValidator
 *
 * @package App\Infrastructure\Groq
 */
final class GroqContentValidator implements ContentValidator
{

    private static string $questionPrompt = <<<EOT
You are a content moderation expert tasked with categorizing user-generated text based on the following guidelines:

%guidelines%

First, inside of <reason> property, identify the reason why the answer in user text should be blocked or not based on the guidelines.
Then you put inside of <appropriate> property a true or false value when you consider the answer appropriate for the question.
Finally, classify this text as either ALLOW or BLOCK inside <output> property.
Return nothing else.

Given those instructions, here is the post to categorize:
<user_text>%user_text%</user_text>

Based on the guidelines above, classify this text as either ALLOW or BLOCK. Return nothing else.
EOT;

    private static string $guidelinesDefault = <<<EOG
BLOCK CATEGORY:
- Promoting violence, illegal activities, or hate speech
- Explicit sexual content
- Harmful misinformation or conspiracy theories

ALLOW CATEGORY:
- Most other content is allowed, as long as it is not explicitly disallowed
EOG;

    private ?string $reason = null;

    public function __construct(private readonly Groq $groqService)
    {
    }

    /**
     * @inheritDoc
     * @throws GroqException
     */
    public function validateContent(string $content, array $context = []): bool
    {
        list($appropriate, $reason) = $this->query($content);
        if (is_string($reason)) {
            $this->reason = $reason;
        }
        return $appropriate;
    }

    /**
     * @inheritDoc
     */
    public function reason(): ?string
    {
        return $this->reason;
    }

    /**
     * @param string $text
     * @return array<{0: bool, 1: string}>
     * @throws GroqException
     */
    private function query(string $text): array {
        $prompt = str_replace(
            ['%user_text%', '%guidelines%'],
            [$text, self::$guidelinesDefault],
            self::$questionPrompt
        );

        $response = $this->groqService->chat()->completions()->create([
            "model" => "llama3-8b-8192",
            "messages" => [
                ["role" => "user", "content" => $prompt],
                [
                    'role' => 'system',
                    'content' => "You are an API and shall respond only with valid JSON.",
                ],
            ],
            'response_format' => ['type' => 'json_object']
        ]);

        $result = json_decode($response['choices'][0]['message']['content'], true);

        return [(bool) $result['appropriate'], $result['reason']];
    }
}
