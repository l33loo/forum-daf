<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Shared;

use App\Application\PaginatedQuery;

/**
 * AbstractPaginatedQuery
 *
 * @package App\Application\Shared
 *
 * @template TKey of int|string
 * @template TValue of mixed
 * @extends AbstractQuery<TKey, TValue>
 * @implements PaginatedQuery<TKey, TValue>
 */
abstract class AbstractPaginatedQuery extends AbstractQuery implements PaginatedQuery
{

    private ?Pagination $pagination = null;
    private ?int $countItems = null;

    /**
     * @inheritDoc
     */
    public function pagination(): Pagination
    {
        if (!$this->pagination) {
            $itemsPerPage = $this->param('rows');
            $currentPage = $this->param('page');
            $totalItems = $this->countItems();

            $this->pagination = new Pagination(
                $itemsPerPage ? (int) $itemsPerPage : Pagination::ITEMS_PER_PAGE,
                $currentPage ? (int) $currentPage : 1,
                $totalItems
            );
        }

        return $this->pagination;
    }

    /**
     * @inheritDoc
     * @return self<TKey,TValue>
     */
    public function withPagination(Pagination $pagination): self
    {
        $this->objects = null;
        $this->pagination = $pagination;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function withParam(string $name, mixed $value): AbstractQuery
    {
        $this->countItems = null;
        return parent::withParam($name, $value);
    }

    /**
     * @inheritDoc
     */
    public function withoutParam(string $name): AbstractQuery
    {
        $this->countItems = null;
        return parent::withoutParam($name);
    }


    /**
     * The number of total rows to paginate
     *
     * @return int
     */
    private function countItems(): int
    {
        if (!$this->countItems) {
            $this->countItems = $this->countQuery();
        }
        return $this->countItems;
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return $this->countItems();
    }


    /**
     * Executes a query to count the total rows for this query
     *
     * @return int
     */
    abstract protected function countQuery(): int;
}
