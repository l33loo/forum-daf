<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\App\Application\Shared;

use App\Application\Shared\Pagination;
use PhpSpec\ObjectBehavior;

/**
 * PaginationSpec
 *
 * @package Application\Shared
 */
final class PaginationSpec extends ObjectBehavior
{
    private $itemsPerPage;
    private $currentPage;
    private $totalItems;

    function let()
    {
        $this->itemsPerPage = 10;
        $this->currentPage = 3;
        $this->totalItems = 100;
        $this->beConstructedWith($this->itemsPerPage, $this->currentPage, $this->totalItems);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Pagination::class);
    }

    function it_has_a_items_per_page()
    {
        $this->itemsPerPage()->shouldBe($this->itemsPerPage);
    }

    function it_has_a_current_page()
    {
        $this->currentPage()->shouldBe($this->currentPage);
    }

    function it_has_a_total_items()
    {
        $this->totalItems()->shouldBe($this->totalItems);
    }

    function it_can_be_created_without_any_arguments()
    {
        $this->beConstructedWith();
        $this->itemsPerPage()->shouldBe(Pagination::ITEMS_PER_PAGE);
        $this->currentPage()->shouldBe(1);
        $this->totalItems()->shouldBe(null);
        $this->hasPreviousPage()->shouldBe(false);
        $this->hasNextPage()->shouldBe(false);
        $this->offset()->shouldBe(0);
        $this->totalPages()->shouldBe(0);
    }

    function its_has_the_total_pages()
    {
        $this->totalPages()->shouldBe(10);
    }

    function it_has_an_offset()
    {
        $this->offset()->shouldBe(20);
    }

    function its_has_a_previous_page_checker()
    {
        $this->hasPreviousPage()->shouldBe(true);
    }

    function its_has_a_next_page_checker()
    {
        $this->hasNextPage()->shouldBe(true);
    }
}
