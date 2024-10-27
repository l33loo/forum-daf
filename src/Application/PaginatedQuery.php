<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application;

use App\Application\Shared\Pagination;

/**
 * PaginatedQuery
 *
 * @package App\Application
 *
 * @template TKey of int|string
 * @template TValue of mixed
 * @extends Query<TKey,TValue>
 */
interface PaginatedQuery extends Query
{
    /**
     * Current pagination setting
     *
     * @return Pagination
     */
    public function pagination(): Pagination;

    /**
     * Sets new pagination to this query
     *
     * This method MUST invalidate data forcing the query with new parameters
     * @param Pagination $pagination
     * @return self<TKey,TValue>
     */
    public function withPagination(Pagination $pagination): self;
}
