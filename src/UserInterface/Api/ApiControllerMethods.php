<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api;


use Slick\JSONAPI\Document\DocumentDecoder;
use Slick\JSONAPI\Document\DocumentEncoder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * ApiControllerMethods
 *
 * @package App\UserInterface\Api
 */
trait ApiControllerMethods
{
    private static array $headers = ['Content-Type' => 'application/vnd.api+json'];
    private DocumentEncoder $encoder;
    private DocumentDecoder $decoder;

    #[Required]
    public function withEncoder(DocumentEncoder $encoder): self
    {
        $this->encoder = $encoder;
        return $this;
    }

    #[Required]
    public function withDecoder(DocumentDecoder $decoder): self
    {
        $this->decoder = $decoder;
        return $this;
    }

    private function apiResponse(mixed $data, int $statusCode = 200, ?array $headers = null): Response
    {
        $headers = $headers ? array_merge(self::$headers, $headers) : self::$headers;
        return new Response(
            $this->encoder->encode($data),
            $statusCode,
            $headers
        );
    }

    /**
     * Decode the given class name using the decoder service
     *
     * @param string $className The class name to decode
     * @return object The decoded object
     */
    private function decodeTo(string $className): object
    {
        return $this->decoder->decodeTo($className);
    }
}
