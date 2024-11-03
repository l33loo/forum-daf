<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\JsonApi;

use App\Infrastructure\Doctrine\User\DoctrineUserList;
use Slick\JSONAPI\Object\AbstractResourceSchema;
use Slick\JSONAPI\Object\ResourceCollectionSchema;

/**
 * UserListSchema
 *
 * @package App\Infrastructure\JsonApi
 */
final class UserListSchema extends AbstractResourceSchema implements ResourceCollectionSchema
{

    /**
     * @inheritDoc
     */
    public function type($object): string
    {
        return "users";
    }

    /**
     * @inheritDoc
     */
    public function identifier($object): ?string
    {
        return null;
    }

    /**
     * @inheritDoc
     * @param DoctrineUserList $object
     */
    public function attributes($object): ?array
    {
        return $object->toArray();
    }

    /**
     * @inheritDoc
     * @param DoctrineUserList $object
     */
    public function meta($object): ?array
    {
        $pag = $object->pagination();
        return [
            'count' => $object->count(),
            'pagination' => [
                'current' => $pag->currentPage(),
                'rows' => $pag->itemsPerPage(),
                'pages' => $pag->totalPages()
            ],
            'params' => $object->params()
        ];
    }

    /**
     * @inheritDoc
     * @param DoctrineUserList $object
     */
    public function links($object): ?array
    {
        $next = [
            'rows' => $object->pagination()->itemsPerPage(),
            'page' => $object->pagination()->currentPage() + 1,
        ];

        $prev = [
            'rows' => $object->pagination()->itemsPerPage(),
            'page' => $object->pagination()->currentPage() - 1,
        ];
        $links = ["self" => true];
        if ($object->pagination()->currentPage() < $object->pagination()->totalPages()) {
            $links["next"] = "/api/users?" . http_build_query($next);
        }
        if ($object->pagination()->currentPage() > 1) {
            $links["previous"] = "/api/users?" . http_build_query($prev);
        }
        return $links;
    }

}
