<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Shared;

/**
 * Pagination
 *
 * @package App\Application\Shared
 */
final readonly class Pagination
{
    public const ITEMS_PER_PAGE = 12;

    /**
     * Creates a Pagination
     *
     * @param int      $itemsPerPage
     * @param int      $currentPage
     * @param int|null $totalItems
     */
    public function __construct(
        private int  $itemsPerPage = self::ITEMS_PER_PAGE,
        private int  $currentPage = 1,
        private ?int $totalItems = null
    ) {
    }

    /**
     * Pagination's items per page
     * @return int
     */
    public function itemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    /**
     * Pagination's current page
     * @return int
     */
    public function currentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * Pagination's total items
     * @return int|null
     */
    public function totalItems(): ?int
    {
        return $this->totalItems;
    }

    /**
     * Pagination's total pages
     *
     * @return int
     */
    public function totalPages(): int
    {
        return (int) ceil((int) $this->totalItems / $this->itemsPerPage);
    }

    /**
     * Pagination's total offset regarding current page
     *
     * @return int
     */
    public function offset(): int
    {
        return ($this->currentPage - 1) * $this->itemsPerPage;
    }

    /**
     * Checks if pagination has a previous page based on current page
     *
     * @return bool
     */
    public function hasPreviousPage(): bool
    {
        return $this->currentPage > 1;
    }

    /**
     * Checks if pagination has a next page based on current page
     *
     * @return bool
     */
    public function hasNextPage(): bool
    {
        return $this->currentPage < $this->totalPages();
    }
}
